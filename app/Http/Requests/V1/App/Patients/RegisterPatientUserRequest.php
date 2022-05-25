<?php

namespace App\Http\Requests\V1\App\Patients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterPatientUserRequest extends FormRequest
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
//            'username' => "unique:App\Models\Authentication\User,username",
//            'email' => "unique:App\Models\Authentication\User,email",
            'username' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'nombre de usuario',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'passwordConfirmation' => 'confirmación de contraseña',
        ];
    }
}
