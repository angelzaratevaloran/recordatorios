<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Colaborador;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cumpleaños = Colaborador::getCumpleañosHoy();
        $aniversarios = Colaborador::getAniversariosHoy();

        return view('home', compact('cumpleaños', 'aniversarios'));
    }

    public function showColaboradores(Request $request){

        $request->user()->authorizeRoles('admin');

        $colaboradores = Colaborador::all();
        return view('colaboradores', compact('colaboradores'));
    }
	
	public function listColaboradores(Request $request){
		$request->user()->authorizeRoles('admin');

        $colaboradores = Colaborador::all();
		return response()->json([
		'code' => 200, 
		'list' =>  $colaboradores
		]);
	}
}
