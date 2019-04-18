<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentOrdersPost extends FormRequest
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
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required'
        ];
    }

    // thong bao loi ra ngoai view
    public function messages()
    {
        return [
            'username.required' => ':attribute khong duoc trong',
            'email.required' => ':attribute khong duoc trong',
            'email.email' => ':attribute khong hop le',
            'phone.required' => ':attribute khong duoc trong',
            'address.required' => ':attribute khong duoc trong'
        ];
    }
}
