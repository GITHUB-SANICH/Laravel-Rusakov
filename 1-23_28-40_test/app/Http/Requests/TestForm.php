<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestForm extends FormRequest
{
	//protected $stopOnFirstFailure = true;
	//protected $redirect = '/';
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
			'name' => 'required|min:2|max:20',
			'text' => 'required|max:100',
			'bd' => 'nullable|date',
        ];
    }
	 
	 public function messages()
	 {
		return [
			'name.required' => 'Поле :attribute обязательно для заполнения!',
		];
	 }

	 public function attributes()
	 {
		return [
			'name' => 'имя',
			'bd' => 'дата рождения',
		];
	 }
}
