<?php

namespace App\Rules;

use Closure;
use App\Models\Hoteles;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUniqueHotel implements DataAwareRule, ValidationRule
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
        $hotel = Hoteles::where('id', '<>', $this->data["id_hotel"])->where($attribute, $value)->get();
        if (count($hotel) > 0) {
            $fail('Ya hay un hotel registrado con el nit ingresado');
        }
    }
}
