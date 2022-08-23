<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UploadImageRequest;
use App\Models\Category;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


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

        $subcategory = Category::whereParentCategoryId($id)->get();

        return response()->json(['desired_category' => $desired_category, 'subcategory' => $subcategory]);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): Response
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
}
