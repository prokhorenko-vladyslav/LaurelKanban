<?php

namespace Laurel\Kanban\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeskStore extends FormRequest
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
            'name' => 'required|unique:desks,name|string:255',
            'description' => 'string:1000',
            'is_favorite' => 'boolean',
            'is_private' => 'boolean'
        ];
    }
}
