@extends('layouts.app')

@section('content')

    <div class="container"> 
        <div class="row">
            <div class="col-xs-4">
                <a class="btn btn-primary btn-xs" href="{{route('plantilla.index')}}" >
                        Mostrar Plantillas
                </a>
                <a class="btn btn-primary btn-xs" href="{{action('PlantillaController@edit', $plantilla->id)}}" >
                        Editar
                </a>
            </div>
        </div>
        <br>
        <div class="row">
            <h4><strong>Nombre de la plantilla: </strong>{{$plantilla->Name}}</h4>
        </div>
        <div class="row">
            <h4><strong>Asunto en el correo: </strong>{{$plantilla->Asunto}}</h4>
        </div>
        <div class="row">
            <h4><strong>Contenido: </strong></h4>
        </div>
        {!!
            $plantilla->Contenido
        !!}
    </div>

@endsection