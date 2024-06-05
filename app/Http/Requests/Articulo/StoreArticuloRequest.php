<?php

namespace App\Http\Requests\Articulo;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticuloRequest extends FormRequest
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
            'nombre' => '',
            'descripcion' => '',
            'fecha_creacion' => '',
            'fecha_vencimiento' => '',
            'serie' => '',
            'tipo_id' => '',
            'imagen' => '',
            'materiales' => '',
        ];
    }
}
