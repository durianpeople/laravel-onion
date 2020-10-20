<?php

namespace App\Http\Middleware;

use App\Modules\Shared\Mechanism\MessageBus;
use Closure;
use Illuminate\Http\Request;

class HoldMessageBus
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
        MessageBus::holdMessages();

        return $next($request);
    }
}
