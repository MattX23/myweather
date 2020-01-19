<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return Auth::check() ?
            view('home')
                ->withUser(Auth::user())
                ->withMessages(json_encode(__('messages'))) :
            view('auth.login');
    }
}
