<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UploadImageRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;


class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Display a listing of parent categories
     *
     * @return JsonResponse
     */
    public function indexParentCategories()
    {
        $categories = Category::whereNull('parent_category_id')->get();
        return response()->json($categories);
    }

    /**
     * Display all categories with its associated products
     *
     * @return Response
     */
    public function indexWithProducts(): Response
    {
        $categoryProducts = Category::with('products.kinds')->paginate();
        return response(['message' => "Hiển thị danh mục thành công", 'category' => $categoryProducts], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return Response
     */
    public function store(StoreCategoryRequest $request): Response
    {
        try {
            $attributes = $this->uploadImage($request);
            Category::create($attributes);
            return response(['message' => "Thêm danh mục mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Thêm danh mục không thành công", "error" => $e], 401);
        }
    }

    /**
     * Display the specified resource and its children
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $desired_category = Category::findOrFail($id);

        $subcategory = $desired_category->children()->get();

        return response()->json(['desired_category' => $desired_category, 'subcategory' => $subcategory]);
    }

    /**
     * Display a specific category and its products.
     *
     * @param int $category_id
     * @return Response
     */
    public function showWithProducts(int $category_id): Response
    {
        $data = Category::with(['products', 'childrenRecursive', 'childrenRecursive.products.kinds', 'products.kinds'])
            ->where('id', $category_id)
            ->get()
            ->toArray();

        $flatten = $this->flatten($data);

        foreach ($flatten as $key => $fl) {
            // eliminate categories from $flatten array
            if (!array_key_exists('category_id', $fl) && !array_key_exists('hex_color', $fl)) {
                unset($flatten[$key]);
            }
        }


        $productsAndKinds = array_values($flatten);

        $products = [];
        $kinds = [];
        foreach ($productsAndKinds as $item) {
            if (array_key_exists('category_id', $item)) $products[] = $item;
            if (array_key_exists('hex_color', $item)) $kinds[] = $item;
        }

        foreach ($products as &$product) {
            foreach ($kinds as $kind) {
                if ($product['id'] === $kind['product_id']) {
                    $product['kinds'][] = $kind;
                }
            }
        }

        $pagination = $this->paginate($products);
        return response([
            'message' => "Hiển thị sản phẩm cho danh mục thành công",
//            'products' => $products,
            'pagination' => $pagination,
        ], 200);

    }

    public function paginate($items, $perPage = 15, $page = null, $options = ['path' => ""])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);
//        echo '<pre>', print_r($items), '</pre>';
        return new LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param EditCategoryRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditCategoryRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $editingCategory = Category::findOrFail($id);

        $imageExistsInDb = file_exists(public_path($request->get('img_url')));

        if ($imageExistsInDb) {
            $editingCategory->update($attributes);
            return response(['message' => "Cập nhật danh mục thành công"], 200);
        } else {
            return response(['message' => "Cập nhật danh mục không thành công"], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            Category::findOrFail($id)->delete();
            return response(["message" => "Đã nhận được yêu cầu xóa danh mục"], 200);
        } catch (QueryException $e) {
            return response(["message" => "Không xóa danh mục được", "error" => $e], 401);
        }
    }


    /**
     * Upload image to public folder, in this case the categories folder
     *
     * @param UploadImageRequest|StoreCategoryRequest $request
     * @return array
     */

    public function uploadImage(UploadImageRequest|StoreCategoryRequest $request): array
    {
        $attributes = $request->all();
        if ($request->hasFile('img_file')) {
            $uploadedFile = $request->file('img_file');
            $name = $uploadedFile->getClientOriginalName();

            $imageName = microtime() . '-' . $name;

            $movedFile = $uploadedFile->storeAs('img/categories', $imageName, ['disk' => 'image']);
            $attributes['img_url'] = '/' . $movedFile;
        }
        return $attributes;
    }

    public function flatten($array): array
    {
        $flatArray = [];
        $kindsArray = [];
        if (!is_array($array)) {
            $array = (array)$array;
        }

//        echo '<pre>', print_r($array), '</pre>';
        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $flatArray = array_merge($flatArray, $this->flatten($value));
            } else {
                $flatArray[0][$key] = $value;
            }
        }
        return $flatArray;
    }
}
