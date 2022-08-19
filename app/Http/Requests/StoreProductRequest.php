<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'image'           => 'required|image|max:2048',
            'images.*'        => 'image|max:2048',
            'product_name'    => 'required|string',
            'category'        => 'required|numeric',
            'color'           => 'required|string',
            'amount'          => 'required|numeric',
            'remain'          => 'required|numeric',
            'price'           => 'required|numeric',
            'discount'        => 'required|numeric',
            'dis_price'       => 'required|numeric',
            'product_details' => 'required|string',
        ];
    }
}