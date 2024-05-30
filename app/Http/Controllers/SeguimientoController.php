<?php

namespace App\Http\Controllers;

use App\Models\GuestData;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function EmailAbierto($id)
    {
        $guestData = GuestData::find($id);

        if ($guestData) {
            // Marca el correo como abierto
            $guestData->email_abierto = 'S';
            $guestData->save();
        }

        // Devuelve una imagen en blanco de 1x1 píxeles
        return response()->file(public_path('images/img.png'), [
            'Content-Type' => 'image/png',
        ]);
    }
}
