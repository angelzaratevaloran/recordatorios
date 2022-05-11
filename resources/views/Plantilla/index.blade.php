@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="table-container">
                <table class="table table-bordred table-striped">
                    <tr>
                        <td>Nombre Plantilla</td>
                        <td>Asunto</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @forelse($plantillas as $p)
                        <tr>
                            <td>{{$p->Name}}</td>
                            <td>{{$p->Asunto}}</td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="{{action('PlantillaController@show', $p->id)}}" >
                                    Mostrar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="{{action('PlantillaController@edit', $p->id)}}" >
                                    Editar
                                </a>
                            </td>
                        </tr>
                        
                    @empty
                        <tr>
                            <td colspan="4">No hay plantillas </td>
                        </tr>
                        
                    @endforelse   
                </table>

            </div>
            


        </div>
    </div>
</div>

@endsection