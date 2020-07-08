<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index() {
        $following = Auth::user()->following;
        $followers = Auth::user()->followers;
        return view('home', compact('following', 'followers'));
    }


}
