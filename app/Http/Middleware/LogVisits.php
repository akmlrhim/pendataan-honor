<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Visit;

class LogVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // bila route saat ini adalah login dan user berhasil login
        if ($request->is('login') && Auth::check()) {
            $this->logVisit($request);
        }

        return $response;
    }

    private function logVisit(Request $request)
    {
        $userId = Auth::id();
        $userAgent = $request->header('User-Agent');
        $browser = $this->detectBrowser($userAgent);

        Visit::create([
            'user_id' => $userId,
            'ip' => $request->ip(),
            'browser' => $browser,
        ]);
    }

    private function detectBrowser($userAgent)
    {
        if (strpos($userAgent, 'Edg') !== false) {
            return 'Microsoft Edge';
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            return 'Google Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Mozilla Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
            return 'Opera';
        } else {
            return 'Unknown';
        }
    }
}
