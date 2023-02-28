<?php

namespace App\Http\Middleware;

use App\Models\Masters\Company\Company;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashCheckBanned
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

        //this is for check the user`s company is block or not  
        if(auth()->guard('dash')->check()){
            $companyStatus = Company::where('id',auth()->guard('dash')->user()->company_id)->value('status');
            if($companyStatus  === 'Blocked'){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('dash')->with('error',__('webCaption.company_error_blocked.title'));
            }
        }

        //this is for check the user is block or not 
        if(auth()->guard('dash')->check() && (auth()->guard('dash')->user()->status === 'Blocked')){

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('dash')->with('error',__('webCaption.error_blocked.title'));

        }

        return $next($request);
    }
}
