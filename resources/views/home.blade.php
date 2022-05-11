@extends('layouts.app')

@section('content')
<div class="container">
<!--
    <div class="row">
        <div class="upload-btn-wrapper col-md-8 col-md-offset-1 ">

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
    <br>-->
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cumpleaños</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                </div>

                <table class="table-striped table">
                    <tr>
                        <td>Nombre</td>
                        <td>Correo</td>
						<td>Pusto</td>						
                        <td>Años</td>
                    </tr>

                    @forelse ($cumpleaños as $var)
                        <tr>
                            <td>{{$var->nombre}}</td>
                            <td>{{$var->correo}}</td>
							<td>{{$var->puesto}}</td>
                            <td>{{\Carbon\Carbon::parse($var->fechaCumpleanios)->age}}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="3">Ningun Cumpleaños hoy.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>


    <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Aniversarios</div>
    
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        
                    </div>
                    <table class="table-striped table">
                            <tr>
                                <td>Nombre</td>
                                <td>Correo</td>
								<td>Puesto</td>
                                <td>Años</td>
                            </tr>
        
                            @forelse ($aniversarios as $var)
                                <tr>
                                    <td>{{$var->nombre}}</td>
                                    <td>{{$var->correo}}</td>
									<td>{{$var->puesto}}</td>
                                    <td>{{\Carbon\Carbon::parse($var->fechaIngreso)->age}}</td>
                                </tr>
        
                            @empty
                                <tr>
                                    <td colspan="3">Ningun Cumpleaños hoy.</td>
                                </tr>
                            @endforelse
                        </table>
                </div>
            </div>
        </div>
</div>
@endsection
