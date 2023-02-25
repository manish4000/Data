<?php

namespace App\Http\Controllers\Dash\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{   
    use SendsPasswordResetEmails;

    protected function guard()
    {
    return Auth::guard('dash');
    }

    protected function broker()
    {
    return Password::broker('company_users');
    }

    public function showLinkRequestForm(){
        return view('dash.auth.passwords.email');
    }  
}
