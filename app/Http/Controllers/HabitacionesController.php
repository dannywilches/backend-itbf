<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitacionRequest;
use App\Http\Requests\UpdateHabitacionesRequest;
use App\Models\Habitaciones;

class HabitacionesController extends Controller
{
    /**
     * Funcion para retornar todos los habitaciones e incluidas los tipos de habitacion
     */
    public function index()
    {
        $habitaciones = Habitaciones::with(['getHotel'])->get();
        return response()->json([
            'habitaciones' => $habitaciones,
        ], 200);
    }

    /**
     * Funcion para crear un nuevo habitacion
     */
    public function store(StoreHabitacionRequest $request)
    {
        $habitacion = new Habitaciones();
        $habitacion->id_hotel = $request->id_hotel;
        $habitacion->num_habs = $request->num_habs;
        $habitacion->tipo_hab = $request->tipo_hab;
        $habitacion->acomodacion = $request->acomodacion;

        $habitacion->save();

        return response()->json([
            'habitacion' => $habitacion,
            'mensaje' => 'Acomodación de habitación registrada',
            'status' => 201,
        ], 201);
    }

    /**
     * Funcion para retornar la información de un habitacion en especifico
     */
    public function show(string $id)
    {
        $habitaciones = Habitaciones::with(['getHotel'])->find($id);
        return response()->json([
            'habitaciones' => $habitaciones,
        ], 200);
    }

    /**
     * Funcion para actualizar un habitacion
     */
    public function update(UpdateHabitacionesRequest $request, string $id)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            return response()->json([
                'mensaje' => 'El habitacion para actualizar no existe',
            ], 204);
        }

        $habitacion->id_hotel = $request->id_hotel;
        $habitacion->num_habs = $request->num_habs;
        $habitacion->tipo_hab = $request->tipo_hab;
        $habitacion->acomodacion = $request->acomodacion;

        $habitacion->save();

        return response()->json([
            'habitacion' => $habitacion,
            'mensaje' => 'Acomodación de habitación actualizada',
            'status' => 201,
        ], 201);
    }

    /**
     * Funcion para eliminar un habitacion
     */
    public function destroy(string $id)
    {
        $habitacion = Habitaciones::find($id);
        if (!$habitacion) {
            return response()->json([
                'mensaje' => 'El habitacion a eliminar no existe',
            ], 404);
        }

        $habitacion->delete();
        return response()->json([
            'mensaje' => 'El asignación fue eliminada',
            'status' => 204,
        ], 204);
    }
}
