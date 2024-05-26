<?php

namespace App\Http\Controllers;
use App\Models\GuestData;
use Illuminate\Http\Request;
use Inertia\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
class GuestDataController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $guests = GuestData::orderBy('created_at', 'desc')->paginate($perPage);

        $guests->getCollection()->transform(function ($guest) {
            $guest->fecha_alta = Carbon::parse($guest->created_at)->format('d/m/Y H:i:s');
            return $guest;
        });

        return Inertia::render('Guests/Index', [
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
        
        $plataforma = $this->isMobile($userAgent) ? 'M' : 'C'; // 'M' para móvil, 'C' para ordenador
        $navegador = $this->getBrowser($userAgent);

        // Guardar datos en la base de datos
        $userData = GuestData::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer' => $referrer,
            'language' => $language,
            'decision' => $decision,
            'navegador' => $navegador,
            'plataforma' => $plataforma,
        ]);
        // Enviar la información a Vue directamente
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
    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'OPR') !== false || strpos($userAgent, 'OPR') !== false) {
            return 'Opera';
        } elseif (strpos($userAgent, 'Edg') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return 'IE';
        }

        return 'Other';
    }
    private function isMobile($userAgent)
    {
        $mobileAgents = ['Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi'];

        foreach ($mobileAgents as $device) {
            if (strpos($userAgent, $device) !== false) {
                return true;
            }
        }

        return false;
    }
}
