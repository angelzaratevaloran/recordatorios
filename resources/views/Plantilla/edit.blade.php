

@extends('layouts.app')

@section('content')

<div class="container">


    <div class="row">


        <form class="" action="{{action('PlantillaController@update', $plantilla->id)}}" method="post">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">

            <div class="row">
                <label for="Name" class="col-md-4 control-label">Nombre de la plantilla</label>

                <div class="col-md-6">
                    <input class="form-control" name="Name" readonly value="{{ $plantilla->Name }}" required autofocus>
                </div>
            </div>
            <br>
            <div class="row">
                <label for="Asunto" class="col-md-4 control-label">Asunto en Correo</label>

                <div class="col-md-6">
                    <input class="form-control" name="Asunto" value="{{ $plantilla->Asunto }}" required autofocus>
                </div>
            </div>
            <br>
            <div class="row">
                <textarea name="Contenido" id="Contenido">
                    {!!$plantilla->Contenido!!}
                </textarea>
            </div>
            <br>
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <input type="submit"  value="Actualizar" class="btn btn-success">
                </div>
                <div class="col-xs-12 col-md-6">
                        <a href="{{ route('plantilla.index') }}" class="btn btn-info " >Atrás</a>
                </div>
            </div>

        </form>

    </div>

</div>




<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
     var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='

    };

    CKEDITOR.replace( 'Contenido' ,options);

    CKEDITOR.on( 'dialogDefinition', function( ev )
   {
      // Take the dialog name and its definition from the event
      // data.
      var dialogName = ev.data.name;
      var dialogDefinition = ev.data.definition;

      // Check if the definition is from the dialog we're
      // interested on (the Link and Image dialog).
      if ( dialogName == 'link' || dialogName == 'image' )
      {
         // remove Upload tab
         dialogDefinition.removeContents( 'Upload' );
      }
   });

</script>

@endsection
