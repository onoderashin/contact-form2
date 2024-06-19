<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     */
    public function authenticate()
    {
        $credentials = $this->only('email', 'password');

        if (! Auth::attempt($credentials, $this->filled('remember'))) {
            $this->throwFailedAuthenticationException();
        }
    }

    /**
     * Get the failed validation response for the request.
     *
     * @return void
     */
    protected function throwFailedAuthenticationException()
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
}