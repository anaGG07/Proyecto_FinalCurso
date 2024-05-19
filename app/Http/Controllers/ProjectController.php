<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Response;


class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::with('user:id,name')->paginate(2);
        return inertia('Projects/Index', [
            'projects' => $projects
        ]);
    }

    public function inicio(Request $request)
{
    $ipAddress = $request->ip();
    $userAgent = $request->header('User-Agent');
    $referrer = $request->headers->get('referer');
    $language = $request->getPreferredLanguage();
    
    $guestData = GuestData::create([
        'ip_address' => $ipAddress,
        'user_agent' => $userAgent,
        'referrer' => $referrer,
        'language' => $language,
        
    ]);

    // Envía la información a Vue directamente
    return inertia('Inicio', $guestData);
}

}
