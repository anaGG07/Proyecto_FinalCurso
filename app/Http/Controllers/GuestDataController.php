<?php

namespace App\Http\Controllers;

use App\Models\GuestData;
use Illuminate\Http\Request;
use Inertia\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Detection\MobileDetect;

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
        
        $detect = new MobileDetect;

        $plataforma = $detect->isMobile() ? 'M' : 'C'; // 'M' para móvil, 'C' para ordenador                
        $navegador = $this->getBrowser($userAgent);
        $so = ($detect->isMobile()) ? ($detect->isiOS()) ? 'iOS' : 'Android' : $this->getOS($userAgent);
   
        // Guardar datos en la base de datos
        $userData = GuestData::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer' => $referrer,
            'language' => $language,
            'decision' => $decision,
            'navegador' => $navegador,
            'plataforma' => $plataforma,
            'so' => $so,
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

        GuestData::updateOrCreate(
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

        return response()->json(['message' => 'Form data recorded successfully.']);
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
    private function getOS($userAgent)
    {
        $osArray = [
            'Windows'   => 'Windows',
            'Macintosh' => 'Mac',
            'Linux'     => 'Linux',
        ];

        foreach ($osArray as $key => $os) {
            if (stripos($userAgent, $key) !== false) {
                return $os;
            }
        }

        return 'Unknown OS';
    }
  
    public function getChartData()
    {
     
        $guests = GuestData::select('created_at')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $labels = $guests->keys();
        $data = $guests->map(function ($guest) {
            return $guest->count();
        });

        return response()->json([
            'labels' => $labels->values(),
            'data' => $data->values(),
        ]);
    
    }
}
