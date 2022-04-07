<?php

namespace App\Http\Middleware;

use App\Models\CompanyProfile;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthCheck
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
        if(!session()->has('sesiuserid') && ($request->path() != '/') && ($request->path() != '/login')){
            return redirect()->route('index.login')->with('error','Mohon login dahulu');
        }
        view()->share([
            'loginuser' => User::find(session()->get('sesiuserid')),
            'applicationcompany' => CompanyProfile::first()
        ]);
        
        return $next($request)->header('Cache-Control','np-cache,no-store,max-age=0,must-revalidates')
                                ->header('Pragma','no-cache')
                                ->header('Expires','Sat 01 Jan 1999 00:00:00 GMT');
    }

    
}
