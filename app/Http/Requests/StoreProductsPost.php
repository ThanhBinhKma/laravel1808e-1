<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreProductsPost extends FormRequest
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
    public function rules(Request $request)
    {
        $id = $request->id;
        $unique = ($id) ? 'unique:products,name_product,'.$id : 'unique:products,name_product';
        $image = ($id) ? '' : 'required';

        return [
            'nameProduct' => 'required|'.$unique.'|min:3',
            'cat' => 'required',
            'color' => 'required',
            'size' => 'required',
            'brands' => 'required|numeric',
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'images' => $image,
            'description' => 'required'
        ];
    }

    // thong bao loi ra ngoai view
    public function messages()
    {
        return [
            'nameProduct.required' => ':attribute khong dc de trong',
            'nameProduct.unique' => ':attribute da ton tai',
            'nameProduct.min' => ':attribute phai lon hon :min ki tu',
            'cat.required' => ':attribute khong dc de trong',
            'color.required' => ':attribute khong dc de trong',
            'size.required' => ':attribute khong dc de trong',
            'brands.required' => ':attribute khong dc de trong',
            'brands.numeric' => ':attribute phai la so',
            'price.required' => ':attribute khong dc de trong',
            'price.numeric' => ':attribute phai la so',
            'qty.required' => ':attribute khong dc de trong',
            'qty.numeric' => ':attribute phai la so',
            'images.required' => ':attribute khong dc de trong',
            'description.required' => ':attribute khong dc de trong'
        ];
    }
}
