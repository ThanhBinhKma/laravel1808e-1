<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckingAdminLoginPost extends FormRequest
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
            // thiet lap cac quy tac (luat) validation cac du lieu tu form gui len
            'username' => 'required|min:3|max:60',
            'password' => 'required|min:3|max:60'
        ];
    }

    public function messages()
    {
        // thong bao loi ra ngoai form
        return [
            'username.required' => ':attribute khong duoc de trong',
            'username.min' => ':attribute khong nho hon :min ki tu',
            'username.max' => ':attribute khong lon hon :max ki tu',
            'password.required' => ':attribute khong duoc de trong',
            'password.min' => ':attribute khong nho hon :min ki tu',
            'password.max' => ':attribute khong lon hon :max ki tu'
        ];
    }
}
