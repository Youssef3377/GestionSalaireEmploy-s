<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeAdminRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ];
    }
    public function messages()
    {
        return  [
            'email.required' => 'Le mail est obligatoire.',
            'email.unique'   => 'Ce mail existe déjà, veuillez en choisir un autre.',
            'email.email'   => 'Ce mail nest pas valide.',

            'name.required' => 'Le nom est obligatoire.',
            'name.unique'   => 'Ce nom existe déjà, veuillez en choisir un autre.',
        ];

    }
}
