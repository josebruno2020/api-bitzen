<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'nome' => 'required|min:2',
            'email' => 'required|email',
            'senha' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Campo :attribute é obrigatório',
            'email.email' => 'Deve ser um e-mail válido!'
        ];
    }
}
