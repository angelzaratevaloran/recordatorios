<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>{{$plantilla->Asunto}}</title>
</head>
<body>
    <div>
        @php
        $replace = array(
            '__Nombre__' => $colaborador->nombre,
            '__Puesto__' => $colaborador->puesto,
            '__JefeDirecto__' => $colaborador->jefeInmediato,
            '__DirectorDeArea__' => $colaborador->director,
			'__Edad__' => \Carbon\Carbon::parse($colaborador->fechaCumpleanios)->age,
			'__NumeroAniversario__' => \Carbon\Carbon::parse($colaborador->fechaIngreso)->age
        );
        echo str_replace(array_keys($replace), array_values($replace), $plantilla->Contenido);
        @endphp

	</div>
</body>
</html>
