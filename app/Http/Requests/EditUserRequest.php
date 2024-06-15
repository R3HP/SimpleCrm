<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            // TODO:// Create a Rule that returns true if email unchanged or should be unique if changed
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->id,'id')],
            'address' => ['nullable'],
            'phone_number' => ['nullable'],
        ];
    }
}
