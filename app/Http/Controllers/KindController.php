<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kind\EditKindRequest;
use App\Http\Requests\Kind\StoreKindRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Models\Kind;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {

        return response([
            'message' => 'Hiển thị các loại của sản phẩm thành công',
            'kinds' => Kind::all(),
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreKindRequest $request
     * @return Response
     */
    public function store(StoreKindRequest $request): Response
    {
        $attributes = $this->uploadImage($request);
        Kind::create($attributes);

        return response(['message' => "Tạo kiểu loại cho sản phẩm thành công"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        return response([
            'message' => 'Lấy kiểu mẫu cho sản phẩm thành công',
            'kind' => Kind::findOrFail($id)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditKindRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditKindRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $editingKind = Kind::findOrFail($id);

        $imageExistsInDb = file_exists(public_path($request->get('img_url')));

        if ($imageExistsInDb) {
            $editingKind->update($attributes);
            return response(['message' => "Cập nhật kiểu loại sản phẩm thành công"], 200);
        }

        return response(['message' => "Cập nhật kiểu loại sản phẩm không thành công"], 401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Kind::find($id)->delete();
        return response(['message' => 'Đã xóa kiểu loại thành công'], 200);
    }

    /**
     * Upload image to public folder, in this case the categories folder
     *
     * @param StoreKindRequest $request
     * @return array
     */

    public function uploadImage(StoreKindRequest $request): array
    {
        $attributes = $request->all();

        if ($request->hasFile('image_file_1')) {
            $uploadedFile = $request->file('image_file_1');
            $name = $uploadedFile->getClientOriginalName();

            $imageName = microtime() . '-' . $name;

            $movedFile = $uploadedFile->storeAs('img/product', $imageName, ['disk' => 'image']);
            $attributes['image_1'] = '/' . $movedFile;
        }

        if ($request->hasFile('image_file_2')) {
            $uploadedFile = $request->file('image_file_2');
            $name = $uploadedFile->getClientOriginalName();

            $imageName = microtime() . '-' . $name;

            $movedFile = $uploadedFile->storeAs('img/product', $imageName, ['disk' => 'image']);
            $attributes['image_2'] = '/' . $movedFile;
        }
        return $attributes;
    }
}
