<?php

namespace App\Http\Controllers;

use DB;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        return view('panel.home');
    }

    public function users() 
    {
        $users = DB::table('users')->where('isAdmin', false)->get();
        return view('panel.users')->with('users', $users);
    }
}
