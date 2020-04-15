<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

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

    public function userList() 
    {
        $users = DB::table('users')->where('isAdmin', false)->get();
        return response()->json($users, 200);
    }

    public function addUser(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->isActive = $request->isActive;
        $user->isAdmin = $request->isAdmin;    
        $user->save();

        return response()->json([
            'message' => 'New user created'
        ]);           
    }
}
