<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    //
    protected $table = 'Colaborador';

    public static function getCumpleañosHoy(){

        return Colaborador::whereMonth('fechaCumpleanios' , date("m"))
                            ->whereDay('fechaCumpleanios', date("d"))->get();
    }


    public static  function getAniversariosHoy(){

        return Colaborador::whereMonth('fechaIngreso' , date("m"))
                            ->whereDay('fechaIngreso', date("d"))->get();
    }


    public static function getAll(){

        return Colaborador::select("nombre as Nombre (s)",
            "nombreCompleto as Nombre Completo",
            "Puesto as Puesto",
            "correo as Correo","fechaCumpleanios as Fecha de Cumpleaños" ,
            "fechaIngreso as Fecha de ingreso" ,
            "jefeInmediato as Jefe inmediato" ,
            "correoJefeInmediato as correo Jefe inmediato",
            "director as Director de área",
            "correoDirector as Correo Director"
             )
            ->get();
    }

}
