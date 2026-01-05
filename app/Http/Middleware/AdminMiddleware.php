<?php
//app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/')
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        if ($user->role !== 'admin') {
            abort(403, 'Akses khusus Admin.');
        }

        return $next($request);
    }
}