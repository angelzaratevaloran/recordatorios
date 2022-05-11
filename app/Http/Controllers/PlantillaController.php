<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plantilla;

class PlantillaController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $request->user()->authorizeRoles('admin');
        $plantillas = Plantilla::all();

        return View('Plantilla.index', compact('plantillas'));
    }




    public function show(Request $request, $id){
        $request->user()->authorizeRoles('admin');

        $plantilla = Plantilla::find($id);
        if($plantilla === null){
            return back();
        }
        else{

            return View('Plantilla.show', compact('plantilla'));
        }

    }


    public function edit(Request $request, $id){
        $request->user()->authorizeRoles('admin');
        $plantilla = Plantilla::find($id);
        if($plantilla === null){
            return back();
        }
        else{

            return View('Plantilla.edit', compact('plantilla'));
        }
    }


    public function update(Request $request, $id){
        $request->user()->authorizeRoles('admin');
        $request->validate([
            'Name' => 'required',
            'Asunto' => 'required'
        ]);

        $plantilla = Plantilla::find($id)->update($request->all());
        
        return redirect()->route('plantilla.show', ['id' => $id]);
    }
}
