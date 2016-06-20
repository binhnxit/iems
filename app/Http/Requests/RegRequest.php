<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegRequest extends Request
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
            'username' => array('required', 'unique:users,username', 'regex:/^[A-Za-z0-9]+$/'),
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'agree' => 'required',

        ];
    }
    public function messages(){
        return [
            'username.regex' => 'username only A-Z, a-z, 0-9',
        ];
    }

}
