<?php

namespace App\Http\Controllers;

use App\User;
use App\Algorithm;
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

    /**
     * User Section
     */

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

    /**
     * Algorithm Section
     */

    public function algorithms() 
    {
        $algorithms = Algorithm::all();
        return view('panel.algorithms')->with('algorithms', $algorithms);
    }

    public function algorithmList() 
    {
        $algorithms = Algorithm::all();
        return response()->json($algorithms, 200);
    }

    public function addAlgorithm(Request $request)
    {
        $algorithm = new Algorithm;
        $algorithm->name = $request->name;
        $algorithm->description = $request->description;
        $algorithm->parameter = $request->parameter;
        $algorithm->reference = $request->reference;  
        $algorithm->save();

        return response()->json([
            'message' => 'Algorithm created'
        ]);           
    }

    public function updateAlgorithm(Request $request)
    {
        $algorithm = Algorithm::whereId($request->id)->firstOrFail();
        $algorithm->name = $algorithm->name;
        $algorithm->description = $request->description;
        $algorithm->parameter = $request->parameter;
        $algorithm->reference = $request->reference;    
        $algorithm->save();

        return response()->json([
            'message' => 'Algorithm updated'
        ]);           
    }

    public function deleteAlgorithm(Request $request)
    {
        $algorithm = Algorithm::whereId($request->id)->firstOrFail();
        $algorithm->delete();

        return response()->json([
            'message' => 'Algorithm deleted'
        ]);          
    }
}
