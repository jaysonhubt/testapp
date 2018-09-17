<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'project_id' => 'bail|required|numeric|exists:projects,id',
            'member_id' => 'bail|required|numeric|exists:members,id',
            'role' => 'bail|required|in:dev,pl,pm,po,sm'
        ];
    }
}
