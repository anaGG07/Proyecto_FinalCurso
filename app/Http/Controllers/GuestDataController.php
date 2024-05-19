<?php

namespace App\Http\Controllers;
use App\Models\GuestData; 
use Illuminate\Http\Request;
use Inertia\Response;


class GuestDataController extends Controller
{
    public function index()
    {
        $guests = GuestData::all();
        return inertia('Guests/Index', [
            'guests' => $guests
        ]);
    }
    public function store(Request $request)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        $referrer = $request->headers->get('referer');
        $language = $request->getPreferredLanguage();

        // Guardar datos en la base de datos
        $userData = GuestData::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer' => $referrer,
            'language' => $language,
        ]);

        // Envía la información a Vue directamente
        return inertia('Inicio', [
            'ipAddress' => $ipAddress,
            'userAgent' => $userAgent,
            'referrer' => $referrer,
            'language' => $language,
        ]);
    }
}
