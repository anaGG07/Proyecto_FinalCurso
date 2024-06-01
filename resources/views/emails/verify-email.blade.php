<!DOCTYPE html>
<html>
<head>
    <title>Verificación de Correo Electrónico</title>
</head>
<body>
    <h1>Hola!</h1>
    
    <p>Haz clic en el botón de abajo para verificar tu dirección de correo electrónico.</p>
    <a href="{{ $url }}" style="background-color: #1c87c9; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">Verificar Correo</a>
    <p>Si no has solicitado esta verificación, no se requiere ninguna acción adicional.</p>
    <img src="{{ $trackingUrl }}" alt="" style="display:none;width:1px;height:1px;">
    <img src="'{{ $pixel }}'" alt="" width="400" style="height:auto;display:block; padding-bottom: 20px;" />
</body>
</html>
