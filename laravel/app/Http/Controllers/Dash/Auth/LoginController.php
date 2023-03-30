<?php

namespace App\Http\Controllers\Dash\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dash\CompanyUsers;
use App\Models\Masters\Company\Company;
use App\Rules\DashReCaptcha;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = 'dashboard';
    
    public function showLoginForm()
    {   
        return view('dash.auth.login',[
            'title' => 'Company Login',
            // 'loginRoute' => 'dash.auth.login',
            // 'forgotPasswordRoute' => 'admin.password.request',
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response'  => ['required', new DashReCaptcha]
        ],[
            'email.required' => __('webCaption.validation_required.title', ['field'=> "Email" ] ),
            'email.email' => __('webCaption.validation_email.title', ['field'=> "Email" ] ),
            'password.required' => __('webCaption.validation_required.title', ['field'=> "Password" ] ),
            'g-recaptcha-response.required' => __('webCaption.validation_required.title', ['field'=> "g-recaptcha-response" ] ),
        ]);

        if(Auth::guard('dash')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authentication passed...

            return redirect()
                ->intended(route('dashhome'))
                ->with('status','You are Logged in as Company!');
        }else{
            return redirect()->back()->with('error',__('webCaption.error_credentials_not_match.title'));
        }

    }


    public function loginWithId(Request $request){

        $id = Crypt::decrypt($request->id);
        $user  = CompanyUsers::where('company_id',$id)->where('user_type',1)->first();
        dd($user);
        Auth::guard('dash')->login($user);
        return redirect('/dashboard');

    }


    public function logout(Request $request)
    {
        auth()->guard('dash')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect()->route('dash');
    }

}
