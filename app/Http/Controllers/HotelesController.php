<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelesRequest;
use App\Http\Requests\UpdateHotelesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HabitacionesTrait;
use App\Models\Hoteles;

class HotelesController extends Controller
{
    use HabitacionesTrait;
    /**
     * Funcion para retornar todos los hoteles e incluidas los tipos de habitacion
     */
    public function index()
    {
        $hoteles = Hoteles::with(['getHabitaciones'])->get();
        return response()->json([
            'hoteles' => $hoteles,
        ], 200);
    }

    /**
     * Funcion para crear un nuevo hotel
     */
    public function store(StoreHotelesRequest $request)
    {
        $hotel = new Hoteles;
        $hotel->nombre = $request->nombre;
        $hotel->direccion = $request->direccion;
        $hotel->ciudad = $request->ciudad;
        $hotel->nit = $request->nit;
        $hotel->num_habs = $request->num_habs;

        $hotel->save();

        return response()->json([
            'hotel' => $hotel,
            'mensaje' => 'Hotel Registrado',
            'status' => 201,
        ], 201);
    }

    /**
     * Funcion para retornar la información de un hotel en especifico
     */
    public function show(string $id)
    {
        $hoteles = Hoteles::with(['getHabitaciones'])->find($id);
        return response()->json([
            'hoteles' => $hoteles,
        ], 200);
    }

    /**
     * Funcion para actualizar un hotel
     */
    public function update(UpdateHotelesRequest $request, string $id)
    {
        $hotel = Hoteles::find($id);

        if (!$hotel) {
            return response()->json([
                'mensaje' => 'El hotel para actualizar no existe',
                'status' => 204,
            ], 204);
        }

        $hotel->nombre = $request->nombre;
        $hotel->direccion = $request->direccion;
        $hotel->ciudad = $request->ciudad;
        $hotel->nit = $request->nit;
        $hotel->num_habs = $request->num_habs;

        $hotel->save();

        return response()->json([
            'hotel' => $hotel,
            'mensaje' => 'El hotel fue actualizado',
            'status' => 201,
        ], 201);
    }

    /**
     * Funcion para eliminar un hotel
     */
    public function destroy(string $id)
    {
        $hotel = Hoteles::find($id);
        if (!$hotel) {
            return response()->json([
                'mensaje' => 'El hotel a eliminar no existe',
                'status' => 204,
            ], 404);
        }
        $valid_acomodaciones = $this->checkAcomodaciones($id);
        if ($valid_acomodaciones) {
            $hotel->delete();
            return response()->json([
                'mensaje' => 'El hotel fue eliminado',
                'status' => 204,
            ], 204);
        }
        else {
            return response()->json([
                'mensaje' => 'El hotel no puede ser eliminado, ya que tiene habitaciones asignadas.',
                'status' => 400,
            ], 400);
        }
    }
}
