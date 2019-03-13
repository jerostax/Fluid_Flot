<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Newsletter;


class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        Newsletter::subscribeOrUpdate($request->input('email'), [], 'newsletter');

        return redirect('/')->with('success', 'Vous êtes inscrit à la Newsletter de FLUID !');
        // dd($request->input());
    }
}