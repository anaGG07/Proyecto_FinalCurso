<?php

namespace App\Http\Controllers;
use App\Models\GuestData;
use Illuminate\Http\Request;
use Inertia\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class GuestDataController extends Controller
{
    public function index()
    {
        $guests = GuestData::all()->map(function ($guest) {
            $guest->fecha_alta = Carbon::parse($guest->created_at)->format('d/m/Y H:i:s');
            return $guest;
        });

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
        $decision = $request->decision;

        // Guardar datos en la base de datos
        $userData = GuestData::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer' => $referrer,
            'language' => $language,
            'decision' => $decision,
        ]);
        // Envía la información a Vue directamente
        return inertia('Welcome', [
            'ipAddress' => $ipAddress,
            'userAgent' => $userAgent,
            'referrer' => $referrer,
            'language' => $language,
            'id' => $userData->id,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')

            ]);
    }
    public function storeCookieDecision(Request $request)
    {

        $validated = $request->validate([
            'ipAddress' => 'required|string',
            'userAgent' => 'required|string',
            'referrer' => 'nullable|string',
            'language' => 'nullable|string',
            'cookies' => 'nullable|string',
            'id' => 'required|integer',
        ]);
        GuestData::updateOrCreate (
            [
                'id' => $validated['id']
            ],[
                'ip_address'    => $validated['ipAddress'],
                'user_agent'    => $validated['userAgent'],
                'referrer'      => $validated['referrer'],
                'language'      => $validated['language'],
                'cookies'      => $validated['cookies'],
                'updated_at'    => now(),
            ]);

        return response()->json(['message' => 'Cookie decision recorded successfully.']);
    }
}
