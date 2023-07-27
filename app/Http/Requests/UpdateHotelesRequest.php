<?php

namespace App\Http\Requests;

use App\Rules\ValidUniqueHotel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required'],
            'direccion' => ['required'],
            'ciudad' => ['required'],
            'nit' => ['required', new ValidUniqueHotel],
            'num_habs' => ['required','numeric','min:1'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del hotel es requerido',
            'direccion.required' => 'La direccion es requerida',
            'ciudad.required' => 'La ciudad es requerida',
            'nit.required' => 'El nit es requerido',
            'num_habs.required' => 'El numero de habitaciónes es requerido',
            'num_habs.min' => 'El numero de habitaciónes debe ser mayor a 1',
        ];
    }
}
