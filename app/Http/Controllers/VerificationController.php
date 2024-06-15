<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    public function showVerificationScreen(){
        return view('Verification.verify_email');
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect(route('dashboard'))->with('success','Email Verified');
    }

    public function resendVerificationEmail(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return redirect()->back()->with('success','Email Has Been Sent!');
    }
    
}
