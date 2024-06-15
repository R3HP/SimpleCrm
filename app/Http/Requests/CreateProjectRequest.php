<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'title' => ['required'],
            'description' => ['required'],
            'deadline' => ['required', 'date'],
            'assigned_user' => ['required', 'exists:users,id'],
            'assigned_client' => ['required', 'exists:clients,id'],
            'status' => ['required'],
        ];
    }
}
