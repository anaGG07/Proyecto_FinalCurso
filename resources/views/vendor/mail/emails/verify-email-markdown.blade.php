@component('mail::message')
# Hola!

Haz clic en el botón de abajo para verificar tu dirección de correo electrónico.

@component('mail::button', ['url' => $url])
Verificar Correo
@endcomponent

Si no has solicitado esta verificación, no se requiere ninguna acción adicional.

<img src="{{ $trackingUrl }}" alt="" style="display:none;width:1px;height:1px;">

Gracias,<br>
{{ config('app.name') }}
@endcomponent
