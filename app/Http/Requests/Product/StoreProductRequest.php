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
        // TODO: TURN OFF AFTER TESTING
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4|max:255|unique:product,name',
            'category_id' => 'required|integer|numeric|min:1',
            'summary' => 'required|string|min:4|max:255',
            'desc' => 'required|string|min:4|max:5000',
            'detail_info' => 'required|string|min:4|max:5000',
            'quantity' => 'required|integer|numeric|min:1|max:10000',
            'SKU' => 'required|string|min:8|max:64|unique:product,SKU',
            'mass' => 'required|integer|numeric|min:1|max:100000',
            'cost_price' => 'required|integer|numeric|min:500|max:100000000',
            'price' => 'required|integer|numeric|min:500|max:100000000',
            'unit' => 'required|string|min:2|max:12',
            'status' => 'required|string|min:2|max:12',
            'merchant_id' => 'required|integer|numeric|min:1',
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

            'category_id.required' => 'Bạn chưa nhập danh mục của sản phẩm',
            'category_id.integer' => 'Sai dữ liệu',
            'category_id.numeric' => 'Sai dữ liệu',
            'category_id.min' => 'Sai dữ liệu',

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

            'quantity.required' => 'Bạn chưa nhập số lượng sản phẩm',
            'quantity.integer' => 'Sai dữ liệu',
            'quantity.numeric' => 'Sai dữ liệu',
            'quantity.min' => 'Số lượng sản phẩm phải là số nguyên dương',
            'quantity.max' => 'Số lượng sản phẩm cần dưới 10000',

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

            'merchant_id.required' => 'Bạn chưa nhập nhà bán của sản phẩm',
            'merchant_id.integer' => 'Sai dữ liệu',
            'merchant_id.numeric' => 'Sai dữ liệu',
            'merchant_id.min' => 'Sai dữ liệu',
        ];
    }
}
