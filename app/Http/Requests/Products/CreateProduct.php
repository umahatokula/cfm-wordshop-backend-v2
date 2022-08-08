<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'sku' => 'required',
            'unit_price' => 'required',
            'categories' => 'required',
            'download_link' => 'required_if:is_digital,on',
            's3_key' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Product Name is required',
            'download_link.required_if' => 'If a product is digital, then a download link is required',
            'image.required' => 'Please upload an album art',
        ];
    }
}
