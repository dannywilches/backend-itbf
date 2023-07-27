<?php

namespace App\Traits;

use App\Models\Habitaciones;

trait HabitacionesTrait {

    /**
     * Funcion para validar que el Hotel a eliminar tenga o no tenga acomodaciones creadas
     */
    public function checkAcomodaciones($id_hotel) :bool {
        $habitaciones = Habitaciones::where('id_hotel', $id_hotel)->get();
        if (!count($habitaciones) > 0) {
            return true;
        }
        return false;
    }
}
?>
