<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
            'name' => 'bail|required|max:50|regex:/^[a-zA-Z0-9 .-]+$/',
            'information' => 'bail|nullable|max:300',
            'phone' => 'bail|required|max:20|regex:/^[0-9()-.+ \/]+$/',
            'dob' => 'bail|required|date|before:today|after:60 years ago',
            'avatar' => 'bail|required|image|mimes:jpg,png,gif|max:10240',
            'position' => 'bail|required|in:intern,junior,senior,pm,ceo,cto,bo',
            'gender' => 'bail|required|in:0,1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Max length of name is 50 character',
            'name.regex' => 'Name only contain alphanumberic, dash, dot and space',
            'information.max' => 'Max length of information is 300 character',
            'phone.required' => 'Phone is required',
            'phone.max' => 'Max length of phone is 20 character',
            'phone.regex' => 'Phone only contain number, round brackets, dash, dot, slash, plus and space',
            'dob.required' => 'Dob is required',
            'dob.date' => 'Dob is invalid datetime format'
        ];
    }
}
