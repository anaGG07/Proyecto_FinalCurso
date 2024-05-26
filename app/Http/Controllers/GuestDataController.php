<?php

namespace App\Http\Controllers;

use App\Models\GuestData;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

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
            'cookies' => 'nullable|string',
            'id' => 'required|integer',
        ]);

        GuestData::updateOrCreate(
            [
                'id' => $validated['id']
            ],
            [
                'cookies' => $validated['cookies'],
                'updated_at' => now(),
            ]
        );

        return response()->json(['message' => 'Cookie decision recorded successfully.']);
    }

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'name' => 'nullable|string',
            'age' => 'nullable|integer',
            'id' => 'required|integer',
        ]);

        $guestData = GuestData::updateOrCreate(
            [
                'id' => $validated['id']
            ],
            [
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'name' => $validated['name'],
                'age' => $validated['age'],
                'updated_at' => now(),
            ]
        );

        if ($guestData->email) {
            $verificationUrl = route('verify.email', ['token' => Str::random(32), 'email' => $guestData->email]);
            Notification::route('mail', $guestData->email)->notify(new VerifyEmail($verificationUrl));
        }

        return response()->json(['message' => 'Form data recorded successfully.']);
    }

    public function verifyEmail(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $guestData = GuestData::where('email', $email)->first();

        if ($guestData) {
            // Marca el correo como verificado
            $guestData->email_verified_at = now();
            $guestData->save();

            return response()->json(['message' => 'Email verified successfully.']);
        }

        return response()->json(['message' => 'Invalid verification link.'], 400);
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
