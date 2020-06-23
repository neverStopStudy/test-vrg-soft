<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
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
            'img' => 'file|max:2048|mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Нужно добавить название книги!',
            'img.max'  => 'Изображение должно быть не больше 2 мб!',
            'img.mimes'  => 'У картинки должен быть тип jpg или png!',
            'img.file'  => 'Добавьте картинку!'
        ];
    }
}
