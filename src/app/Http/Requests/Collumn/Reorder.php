<?php

namespace Laurel\Kanban\App\Http\Requests\Collumn;

use Illuminate\Foundation\Http\FormRequest;

class Reorder extends FormRequest
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
             'order' => 'required|array',
             'order.*' => 'required|numeric|min:0'
         ];
    }
}
