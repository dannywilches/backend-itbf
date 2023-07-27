<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Habitaciones;

class ValidRepeatCreate implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valid = Habitaciones::where('id_hotel', $this->data["id_hotel"])->where($attribute, $value)->get();
        if (count($valid) > 0){
            if ($attribute == "tipo_hab") {
                $fail("Ya existe un registro de este hotel con el tipo de habitación seleccionado");
            }
            elseif ($attribute == "acomodacion") {
                $fail("Ya existe un registro de este hotel con la acomodacion seleccionada");
            }
        }
    }
}
