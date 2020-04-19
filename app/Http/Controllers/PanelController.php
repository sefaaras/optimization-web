<?php

namespace App\Http\Controllers;

use App\User;
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
        $users = User::where('isAdmin', false)->get();
        return view('panel.users')->with('users', $users);
    }

    public function userList() 
    {
        $users = User::where('isAdmin', false)->get();
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
            'message' => 'User created'
        ]);           
    }

    public function updateUser(Request $request)
    {
        $user = User::whereId($request->id)->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->isActive = $request->isActive;
        $user->isAdmin = $request->isAdmin;    
        $user->save();

        return response()->json([
            'message' => 'User updated'
        ]);           
    }

    public function deleteUser(Request $request)
    {
        $user = User::whereId($request->id)->firstOrFail();
        $user->delete();

        return response()->json([
            'message' => 'User deleted'
        ]);          
    }
}
