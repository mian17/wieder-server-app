<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
//        if (auth()->user()->isAdmin()) {
//            return true;
//        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        \Log::debug($this->request->all());
        return [
            'name' => 'required|string|min:4|max:255|unique:product,name',
            'brand' => 'required|string|min:4|max:255',
            'category_id' => 'required|integer|numeric|min:1|exists:category,id',
            'summary' => 'required|string|min:4|max:255',
            'desc' => 'required|string|min:4|max:5000',
            'detail_info' => 'required|string|min:4|max:5000',
//            'quantity' => 'required|integer|numeric|min:1|max:10000',
            'SKU' => 'required|string|min:8|max:64|unique:product,SKU',
            'mass' => 'required|integer|numeric|min:1|max:100000',
            'cost_price' => 'required|integer|numeric|min:500|max:100000000',
            'price' => 'required|integer|numeric|min:500|max:100000000',
            'unit' => 'required|string|min:1|max:2',
            'status' => 'required|string|min:2|max:12',

            'merchant_ids' => 'required|string',
            'merchant_ids.*' => 'required|numeric|integer|min:1|exists:merchant,id',

            'warehouse_ids' => 'required|string',
            'warehouse_ids.*' => 'required|numeric|integer|min:1|exists:warehouse,id',

            'models' => 'required|array',
            'models.*.name' => 'required|string|min:4|max:255|unique:model,name',
            'models.*.image_1' => 'required|image|mimes:png,jpg,jpeg|dimensions:ratio=1|max:2048',
            'models.*.quantity' => 'required|integer|numeric|min:1|max:10000',
            'models.*.image_2' => 'nullable|sometimes|image|mimes:png,jpg,jpeg|dimensions:ratio=1|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Bạn cần nhập tên sản phẩm',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Tên sản phẩm ngắn quá',
            'name.max' => 'Tên sản phẩm dài quá',
            'name.unique' => 'Đã tồn tại tên sản phẩm này',

            'brand.required' => 'Bạn cần nhập tên hãng của sản phẩm',
            'brand.string' => 'Sai dữ liệu',
            'brand.min' => 'Tên hãng của sản phẩm ngắn quá',
            'brand.max' => 'Tên hãng của sản phẩm dài quá',

            'category_id.required' => 'Bạn chưa nhập danh mục của sản phẩm',
            'category_id.integer' => 'Sai dữ liệu',
            'category_id.numeric' => 'Sai dữ liệu',
            'category_id.min' => 'Sai dữ liệu',
            'category_id.exists' => 'Không tòn tại danh mục này',

            'summary.required' => 'Bạn cần nhập tóm tắt cho sản phẩm',
            'summary.string' => 'Sai dữ liệu',
            'summary.min' => 'Tóm tắt cho sản phẩm ngắn quá',
            'summary.max' => 'Tóm tắt cho sản phẩm dài quá',

            'desc.required' => 'Bạn cần nhập mô tả cho sản phẩm',
            'desc.string' => 'Sai dữ liệu',
            'desc.min' => 'Mô tả cho sản phẩm ngắn quá',
            'desc.max' => 'Mô tả cho sản phẩm dài quá',

            'detail_info.required' => 'Bạn cần nhập thông tin chi tiết cho sản phẩm',
            'detail_info.string' => 'Sai dữ liệu',
            'detail_info.min' => 'Thông tin chi tiết cho sản phẩm ngắn quá',
            'detail_info.max' => 'Thông tin chi tiết cho sản phẩm dài quá',

//            'quantity.required' => 'Bạn chưa nhập số lượng sản phẩm',
//            'quantity.integer' => 'Sai dữ liệu',
//            'quantity.numeric' => 'Sai dữ liệu',
//            'quantity.min' => 'Số lượng sản phẩm phải là số nguyên dương',
//            'quantity.max' => 'Số lượng sản phẩm cần dưới 10000',

            'SKU.required' => 'Bạn cần nhập SKU của sản phẩm',
            'SKU.string' => 'Sai dữ liệu',
            'SKU.min' => 'SKU của bạn cần trên 8 ký tự',
            'SKU.max' => 'SKU của bạn cần dưới 64 ký tự',
            'SKU.unique' => 'SKU của bạn đã tồn tại',

            'mass.required' => 'Bạn chưa nhập khối lượng của sản phẩm theo đơn vị gram',
            'mass.integer' => 'Sai dữ liệu',
            'mass.numeric' => 'Sai dữ liệu',
            'mass.min' => 'Khối lượng của sản phẩm phải là số nguyên dương',
            'mass.max' => 'Khối lượng của sản phẩm cần dưới 100000g',

            'cost_price.required' => 'Bạn chưa nhập giá vốn của sản phẩm',
            'cost_price.integer' => 'Sai dữ liệu',
            'cost_price.numeric' => 'Sai dữ liệu',
            'cost_price.min' => 'Giá vốn của sản phẩm phải trên 500 VNĐ',
            'cost_price.max' => 'Giá vốn của sản phẩm phải dưới 100.000.000 VNĐ',

            'price.required' => 'Bạn chưa nhập đơn giá của sản phẩm',
            'price.integer' => 'Sai dữ liệu',
            'price.numeric' => 'Sai dữ liệu',
            'price.min' => 'Đơn giá của sản phẩm phải trên 500 VNĐ',
            'price.max' => 'Đơn giá của sản phẩm phải dưới 100.000.000 VNĐ',

            'unit.required' => 'Bạn cần nhập đơn vị cho sản phẩm',
            'unit.string' => 'Sai dữ liệu',
            'unit.min' => 'Đơn vị cho sản phẩm ngắn quá',
            'unit.max' => 'Đơn vị cho sản phẩm dài quá',

            'status.required' => 'Bạn cần nhập trạng thái cho sản phẩm',
            'status.string' => 'Sai dữ liệu',
            'status.min' => 'Trạng thái sản phẩm ngắn quá',
            'status.max' => 'Trạng thái sản phẩm dài quá',


            'merchant_ids.required' => 'Bạn cần nhập nhà bán của sản phẩm',
            'merchant_ids.string' => 'Sai dữ liệu',

            'merchant_ids.*.required' => 'Bạn cần nhập nhà bán của sản phẩm',
            'merchant_ids.*.integer' => 'Sai dữ liệu',
            'merchant_ids.*.numeric' => 'Sai dữ liệu',
            'merchant_ids.*.min' => 'Sai dữ liệu',
            'merchant_ids.*.exists' => 'Không tồn tại nhà bán này',

            'warehouse_ids.required' => 'Bạn cần nhập nhà kho của sản phẩm',
            'warehouse_ids.string' => 'Sai dữ liệu',

            'warehouse_ids.*.required' => 'Bạn cần nhập nhà kho của sản phẩm',
            'warehouse_ids.*.integer' => 'Sai dữ liệu',
            'warehouse_ids.*.numeric' => 'Sai dữ liệu',
            'warehouse_ids.*.min' => 'Sai dữ liệu',
            'warehouse_ids.*.exists' => 'Không tồn tại nhà kho này',


            'models.required' => 'Sản phẩm phải có kiểu loại',
            'models.array' => 'Sai dữ liệu',

            'models.*.name.required' => 'Kiểu loại cần có tên',
            'models.*.name.string' => 'Sai dữ liệu',
            'models.*.name.min' => 'Tên kiểu loại ngắn quá',
            'models.*.name.max' => 'Tên kiểu loại dài quá',
            'models.*.name.unique' => 'Tên kiểu loại này đã tồn tại',

            'models.*.image_1.required' => 'Kiểu loại này cần hình cover',
            'models.*.image_1.image' => 'Tập tin của kiểu loại này cần có định dạng hình',
            'models.*.image_1.mimes' => 'Tập tin của kiểu loại này cần có định dạng hình như sau: png, jpg, jpeg',
            'models.*.image_1.dimensions' => 'Hình của kiểu loại cần phải là tỷ lệ 1:1 để không phá vỡ layout của trang web',
            'models.*.image_1.max' => 'Hình của kiểu loại cần phải bé hơn 2mb',

            'models.*.quantity.required' => 'Kiểu loại cần phải có số lượng',
            'models.*.quantity.integer' => 'Sai dữ liệu',
            'models.*.quantity.numeric' => 'Sai dữ liệu',
            'models.*.quantity.min' => 'Số lượng của kiểu loại phải lớn hơn 1',
            'models.*.quantity.max' => 'Số lượng của kiểu loại phải bé hơn 10000',

            'models.*.image_2.image' => 'Tập tin hình on hover của kiểu loại này cần có định dạng hình',
            'models.*.image_2.mimes' => 'Tập tin hình on hover của kiểu loại này cần có định dạng hình như sau: png, jpg, jpeg',
            'models.*.image_2.dimensions' => 'Hình của kiểu loại cần phải là tỷ lệ 1:1 để không phá vỡ layout của trang web',
            'models.*.image_2.max' => 'Hình của kiểu loại cần phải bé hơn 2mb',
        ];
    }
}
