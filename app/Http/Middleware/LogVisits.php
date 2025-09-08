<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = now()->toDateString();
        $userId = Auth::id();

        // cek apakah sudah tercatat hari ini
        $exists = Visit::when($userId, function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }, function ($q) use ($request) {
            $q->where('ip', $request->ip());
        })
            ->whereDate('created_at', $today)
            ->exists();

        if (! $exists) {
            Visit::create([
                'user_id' => $userId,
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
