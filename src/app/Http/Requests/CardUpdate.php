<?php

namespace Laurel\Kanban\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardUpdate extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'string|max:60000',
            'order' => 'numeric|min:0',
            'collumn_id' => 'numeric|exists:collumns,id'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => 'trim|escape',
            'description' => 'trim|escape',
        ];
    }
}
