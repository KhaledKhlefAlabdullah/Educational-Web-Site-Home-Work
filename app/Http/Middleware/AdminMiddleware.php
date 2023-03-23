<?php

namespace App\Http\Middleware;

use App\Models\Details;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $type = Details::where('user_id', $user->id)->value('user_type');

        if ($user && $type==='admin') {
            return $next($request);
        }

        return redirect('/');
    }
}
