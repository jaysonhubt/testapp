<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'name' => 'bail|required|max:10|regex:/^[a-zA-Z0-9 .-]+$/',
            'information' => 'bail|nullable|max:300',
            'deadline' => 'bail|nullable|date',
            'type' => 'bail|required|in:lab,single,acceptance',
            'status' => 'bail|required|in:planned,onhold,doing,done,cancelled'
        ];
    }
}
