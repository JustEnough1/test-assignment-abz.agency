<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|min:2|max:60',
            'email' => 'required|email:rfc|unique:App\Models\User,email',
            'phone' => 'required|regex:/(\+380)[0-9]{9}/|unique:App\Models\User,phone',
            'position_id' => 'required|numeric|exists:App\Models\Position,id',
            'photo' => 'required|mimes:jpg,jpeg|max:5120|dimensions:min_width=70,min_height=70',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $failedRules = $validator->failed();

        // Check if email or username aren't unique
        if (isset($failedRules['email']['Unique']) || isset($failedRules['phone']['Unique'])) {
            $response = response()->json([
                'success' => false,
                'message' => 'User with this phone or email already exist',
            ], 409);
        } else {
            $response = response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
            ], 422);
        }

        throw new ValidationException($validator, $response);
    }
}
