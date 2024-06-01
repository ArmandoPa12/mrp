<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre'=>'',
            'apellido_p'=>'',
            'apellido_m'=>'',
            'nacimiento'=>'',
            'ci'=>'',
            'rol_id'=>'',
            'photo'=>'',
            'correo'=>'',
            'username'=>'',
            'password'=>'',
        ];
    }
}
