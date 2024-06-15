<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermsAcceptRequest;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function index()
    {
        return view('Term.index');
    }

    public function store(TermsAcceptRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return redirect()->intended(route('home'));
    }
}
