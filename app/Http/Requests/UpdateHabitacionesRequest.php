<?php

namespace App\Http\Requests;

use App\Rules\ValidNumHabsUpdate;
use App\Rules\ValidRepeatUpdate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHabitacionesRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
            'id_hotel' => ['required'],
            'num_habs' => ['required','numeric','min:1', new ValidNumHabsUpdate],
            'tipo_hab' => ['required', new ValidRepeatUpdate],
            'acomodacion' => ['required', new ValidRepeatUpdate],
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
            'id_hotel.required' => 'El hotel es requerido',
            'num_habs.required' => 'El número de habitaciones es requerido',
            'num_habs.min' => 'El número de habitaciones es minimo 1',
            'tipo_hab.required' => 'El tipo de habitación es requerido',
            'acomodacion.required' => 'La acomodación es requerido',
        ];
    }
}
