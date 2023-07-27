<?php

namespace App\Rules;

use Closure;
use App\Models\Hoteles;
use App\Models\Habitaciones;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;

class ValidNumHabsCreate implements DataAwareRule, ValidationRule
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
        $hotel_num_habs = Hoteles::find($this->data["id_hotel"]);
        $valid_num_habs = Habitaciones::where('id_hotel', $this->data["id_hotel"])->get()->sum('num_habs');
        if (($valid_num_habs + $value) > $hotel_num_habs->num_habs) {
            $fail('No puede asignar esa cantidad de habitaciones ('.$value.') ya que no puede exceder la cantidad de habitaciones asignadas para este hotel. Hay asignadas '.$valid_num_habs. ' y el limite son '.$hotel_num_habs->num_habs);
        }
    }
}
