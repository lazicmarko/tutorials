<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if($request->session()->has('user')){
            $korisnik = $request->session()->get('user')[0];
            if($korisnik->naziv == 'korisnik'){
                return $next($request);
            } else {
                return redirect()->back()->with('error','Nemate pravo pristupa ovoj stranici!');
            }
        }
        return redirect()->back()->with('error','Nemate pravo pristupa ovoj stranici!');
    }
}
