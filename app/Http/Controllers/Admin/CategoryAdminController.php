<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\String_;

class CategoryAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $parentCategories = Category::whereNull('parent_category_id')->with('childrenRecursive')->get();
        return response()->json($parentCategories);
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
//            echo '<pre>', print_r($request->all()), '</pre>';
            $attributes = $request->except('image');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $movedPath = '/' . uploadFile($file, 'img/categories');
                $attributes['img_url'] = $movedPath;
                Category::create($attributes);
            }
            return response(['message' => "Thêm danh mục mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Thêm danh mục không thành công"], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $desiredCategory = Category::findOrFail($id);
        return response()->json($desiredCategory);
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
        $attributes = $request->except('image');
        $editingCategory = Category::findOrFail($id);

        if ($editingCategory->id === (int)$attributes['parent_category_id']) {
            return response(['message' => 'Bạn không được gắn danh mục như thế này!'], 422);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $attributes['img_url'] = '/' . uploadFile($file, 'img/categories');
        } else if (is_string($request->get('image'))) {
            $attributes['img_url'] = $request->get('image');
        }


        $editingCategory->update($attributes);
        return response(['message' => 'Đã cập nhật danh mục thành công'], 200);
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
            if (auth()->user()->tokenCan('admin')) {
                $relatedCategoriesIds = Category::where('parent_category_id', $id)
                    ->pluck('id')
                    ->toArray();

                array_unshift($relatedCategoriesIds, $id);
//                echo '<pre>', print_r($relatedCategoriesIds), '</pre>';

                if (count($relatedCategoriesIds) > 1) {
                    return response(['message' => 'Bạn phải xóa các sản phẩm, kiểu loại, danh mục con có liên quan đến danh mục này thì mới có thể xóa danh mục được.'], 422);
                }

                $products = Product::whereIn('category_id', $relatedCategoriesIds)->get();

                if (count($relatedCategoriesIds) === 1 && count($products) > 0) {
                    return response(['message' => 'Danh mục này còn chứa nhiều sản phẩm và kiểu loại của chúng. Vì thế, không thể xóa được danh mục này.'], 422);

                }
                Category::findOrFail($id)->delete();
                return response(["message" => "Xóa danh mục thành công"], 200);
            }
            return response(['message' => 'Chỉ có admin mới có quyền xóa danh mục'], 401);

        } catch (QueryException $e) {
            return response(["message" => "Không xóa danh mục được", "error" => $e], 401);
        }
    }
}
