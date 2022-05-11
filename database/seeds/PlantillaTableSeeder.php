<?php

use Illuminate\Database\Seeder;
use App\Plantilla;


class PlantillaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $plantilla = new Plantilla;
        $plantilla->Name = 'Cumpleaños';
        $plantilla->Asunto = 'Felicitaciones de Cumpleaños';
        $plantilla->Contenido = '';
        $plantilla->save();

        $plantilla = new Plantilla;
        $plantilla->Name = 'Aniversario laboral';
        $plantilla->Asunto = 'Felicitaciones por Aniversario laboral';
        $plantilla->Contenido = '';
        $plantilla->save();

        
    }
}
