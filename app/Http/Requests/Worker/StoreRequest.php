<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'age' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_married' => 'nullable|boolean',
            //'is_married' => 'nullable|string', // нужно для предыдущей работы с интерфейсом
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Это поле необходимо для заполнения',
            'name.string' => 'Это поле должно быть строкой',
            'surname.required' => 'Это поле должно быть строкой',
            'surname.string' => 'Это поле должно быть строкой',
            'email.required' => 'Это поле необходимо для заполнения',
            'email.email' => 'Это поле должно в формате Емайл',
            'description.string' => 'Это поле должно быть строкой',
        ];
    }
}
