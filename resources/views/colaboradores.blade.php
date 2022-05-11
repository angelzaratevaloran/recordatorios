@extends('layouts.app')

@section('content')


<div class="container">

    @if (isset($noInsertados))
		
			@if(count($noInsertados) > 0)
            <div class="alert alert-danger">
                <strong>Registros con errores</strong>
			@endif
                @forelse ($noInsertados as $n)
                <ul>
                    <li>{{$n->name}}</li>
                </ul>
                @empty

                @endforelse
			@if(count($noInsertados) > 0)
                Verifique los datos en el excel importado
				
            </div>
			@endif

    @endif
    <div class="row">
        <div class="upload-btn-wrapper col-md-8 ">

        <form method="POST" action="{{ action('ExcelController@import') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <button class="btn">Importar archivo</button>
            <input type="file" name="excel" onchange="this.form.submit()" />
        </form>
        </div>
        <div>
            <form method="POST" action="{{ action('ExcelController@export') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <button class="btn" onclick="this.form.submit()">Descargar archivo</button>
            </form action="">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Colaboradores</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>

                <table class="table">
                    <tr>
                        <td>Nombre</td>
                        <td>Correo</td>
						<td>Puesto</td>
                        <td>Fecha de Cumpleaños</td>
                        <td>Fecha de Ingreso</td>
                        <td>Jefe Inmediato</td>
                        <td>Correo Jefe Inmediato</td>
                    </tr>

                    @forelse ($colaboradores as $var)						
                        <tr>						
						    <td>{{$var->nombre}}</td>
                            <td>{{$var->correo}}</td>
							<td>{{$var->puesto}}</td>
                            <td>{{$var->fechaCumpleanios}}</td>
                            <td>{{$var->fechaIngreso}}</td>
                            <td>{{$var->jefeInmediato}}</td>
                            <td>{{$var->correoJefeInmediato}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Sin Registros.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
