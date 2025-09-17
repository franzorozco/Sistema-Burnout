<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users,email',
            'name' => 'required|string',
            'paternal_surname' => 'string',
            'maternal_surname' => 'string',
            'phone' => 'string',
            'address' => 'string',
            'is_active' => 'required|boolean',
            'password' => 'required|string|confirmed|min:6',
        ];
    }
}