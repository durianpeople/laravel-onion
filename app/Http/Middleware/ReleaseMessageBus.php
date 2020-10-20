<?php

namespace App\Http\Middleware;

use App\Modules\Shared\Mechanism\MessageBus;
use Closure;
use Illuminate\Http\Request;

class ReleaseMessageBus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        MessageBus::releaseMessages();

        return $response;
    }
}
