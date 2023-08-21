<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->vip) {
            return $next($request);
        }
        $isEligible = strtotime('+1 days', strtotime(auth()->user()->created_at));
        $currentDate = strtotime("now");
        if($isEligible > $currentDate){
            return $next($request);
        }

        if (auth()->user()->subscribed('default')) {
            return $next($request);
        } else {
            if (auth()->user()->stripe_id) {
                return redirect('manage-billing');
            }
            return redirect('plans');
        }
    }
}
