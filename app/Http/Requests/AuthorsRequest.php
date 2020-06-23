<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorsRequest extends FormRequest
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
            'name' => 'required',
            'surname' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Добавьте имя автора!',
            'surname.min'  => 'Фамилия должна быть не меньше 3 символов!',
        ];
    }
}
