<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ambil ID dari parameter route (misal parameter routenya bernama 'role' atau 'id')
        // Sesuaikan 'role' dengan nama parameter di route: Route::put('/roles/{role}', ...)
        $roleId = $this->route('role') ?? $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Gunakan Rule::unique dan abaikan ID HANYA JIKA ID-nya ada
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
        ];
    }
}
