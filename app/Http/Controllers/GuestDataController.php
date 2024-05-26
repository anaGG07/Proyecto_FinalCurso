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

        $totalRegistros = GuestData::count();
        $soData = $this->dataSO($totalRegistros);

        return Inertia::render('Guests/Index', [
            'guests'            => $guests,
            'totalRegistros'    => $totalRegistros,
            'soData'            => $soData
            
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

    private function dataSO($totalRegistros){
        
        $totalAndroid = GuestData::where('so', 'Android')->count();
        $totaliOs = GuestData::where('so', 'iOS')->count();
        $totalMac = GuestData::where('so', 'Mac')->count();
        $totalWindows = GuestData::where('so', 'Windows')->count();
        $totalLinux = GuestData::where('so', 'Linux')->count();
        $otroSO = $totalRegistros - ($totalAndroid + $totaliOs + $totalLinux + $totalWindows + $totalMac);
        $movil = GuestData::where('plataforma', 'M')->count();
        $pc = GuestData::where('plataforma', 'C')->count();
        
        $os = [
            'Windows'   => $totalWindows,
            'Macintosh' => $totalMac,
            'Linux'     => $totalLinux,
            'Android'   => $totalAndroid,
            'iOS'       => $totaliOs,
            'otros'     => $otroSO,
            
        ];

        $device = [
            'ordenador' => $pc,
            'movil'     => $movil,
        ];

        $rt = [
            $os,
            $device,
        ];

        
        return $rt;
    }
}
