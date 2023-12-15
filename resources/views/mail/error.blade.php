<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>WS Goucargo Error</title>
</head>

<body>
    <h2><b>Error en el proyecto: PANEL GOUCARGO WEBSERVICE</b></h2>

    <h3><i>Información del error:<i></h3>

    <ul>
        <li><b><u>Usuario registrado</u>:</b>  {{ $mail->user_logged }}.</li>
        <li><b><u>Error</u>:</b> {{ $mail->error }}.</li>
    </ul>
</body>

</html>
