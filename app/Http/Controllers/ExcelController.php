<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Colaborador;
use App\NoInsertados;


class ExcelController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth');
    }


    public function import(Request $request){


        $request->user()->authorizeRoles('admin');

        if($request->hasFile('excel')){

            $file = $request->file('excel');
            $extension = $file->getClientOriginalExtension();

            if($extension == 'xls' || $extension == 'xlsx' ){

                $destinationPath = 'ExcelFiles/';
                $filename='ExcelUpdload_at_'.date("d_m_Y").'.'.$extension;

                $uploadSuccess = $request->file('excel')
                ->move($destinationPath, $filename);

                $noInsertados =  $this->loadData($destinationPath.$filename);
            }
            else
            {
                Session::flash('ExcelError' , 'Archivo no valido');
            }

        }
        else
        {
            Session::flash('ExcelError', 'Archivo no Cargado Correctamente');

        }

        $colaboradores = Colaborador::all();
        return view('colaboradores', compact('colaboradores', 'noInsertados'));
    }

    public function export(Request $request){

        $request->user()->authorizeRoles('admin');

        \Excel::create('Colaboradores', function($excel){

            // Set the title
            $excel->setTitle('Registros de Cumpleaños y Aniversarios');

            // Chain the setters
            $excel->setCreator('Valoran')
            ->setCompany('Valoran.com.mx');

            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');
					
			
            $excel->sheet('hoja 1', function($sheet){
			$sheet->setAutoSize(true);
			$sheet->setColumnFormat(array(				
				'E' => '@',
				'F' => '@'
			));
			$sheet->freezeFirstRow();		

			$colaboradores = Colaborador::getAll();
			$sheet->fromArray($colaboradores);


            });

        })->export('xlsx');


    }


    private function loadData($filename){
        ini_set('memory_limit', '-1');

		ini_set('max_execution_time', 180); //3 minutes
		$fechaInicialExcel = 
        // config(['excel.import.dates.columns' => [
            // 'fecha_de_cumpleanos',
            // 'fecha_de_ingreso'
        // ]]);
        Colaborador::truncate();
        NoInsertados::truncate();
        \Excel::filter('chunk')->load($filename)->chunk(1000, function($result){
            //$result = $archivo->get();

            foreach ($result as $key => $value) {
                $colaborador = new Colaborador;

                $colaborador->nombre = $value->nombre_s?$value->nombre_s:$value->nombre;
                $colaborador->nombreCompleto = $value->nombre_completo?$value->nombre_completo:$value->nombre_colaborador;
                $colaborador->puesto = $value->puesto;

                $colaborador->correo = filter_var( strtolower($value->correo), FILTER_SANITIZE_STRING);
				if(is_numeric($value->fecha_de_cumpleanos))
				{
						$colaborador->fecha_excel = $value->fecha_de_cumpleanos;
				}
				else{
					$colaborador->fechaCumpleanios = $value->fecha_de_cumpleanos;
				}
				
                 //->format('Y-m-d');
                
				
				if(is_numeric($value->fecha_de_ingreso))
				{
					$colaborador->fecha_excel_ingreso = $value->fecha_de_ingreso;//->format('Y-m-d');
				}
				else{
					$colaborador->fechaIngreso = $value->fecha_de_ingreso;//->format('Y-m-d');
				}										
                $colaborador->jefeInmediato = $value->jefe_inmediato;
                $colaborador->correoJefeInmediato = $value->correo_jefe_inmediato;
                $colaborador->director = $value->director_de_area;
                $colaborador->correoDirector = $value->correo_director;								
				
				$colaborador->save();
                try {
					$colaborador->save();
                    
                } catch (\Exception $e) {
                    $noInsertados = new NoInsertados;
                    $noInsertados->name = $colaborador->nombreCompleto;
					$noInsertados->LogMessage = $e->getMessage();
                    try {
                        $noInsertados->save();
                    } catch (\Exception $e) {
                    }
                }
            }
        }, false);
        return noInsertados::all();
    }
}
