<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
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
        // dd($this->request);
        switch ($this->method()) {
            case "POST": {
                return [
                    'nombre' => 'required|string|min:3|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => 'required|string|min:8|confirmed',
                    'ap_paterno' => 'required|string|min:3|max:255',
                    'ap_materno' => 'nullable|string|min:3|max:255',
                    'ci' => 'required|string|min:5|max:255',
                    'telefono' => 'required|string|max:255',
                    'imagen' => 'nullable|image',
                ];
            }
            case "PUT": {
                return [
                    'nombre' => 'required|string|min:3|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,'.$this->route('usuario.id'),
                    'ap_paterno' => 'required|string|min:3|max:255',
                    'ap_materno' => 'nullable|string|min:3|max:255',
                    'ci' => 'required|string|min:5|max:255',
                    'telefono' => 'required|string|max:255',
                    'imagen' => 'nullable|image',
                ];
            }
            default: {
                return [];
            }
        }
    }
}
