<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Mixed_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('layouts/admin-temp/home');
    }

    public function users_list()
    {
        // $users = User::with('roles')->where('user_id', Auth::id())->get();
        $users = User::all();
        $users_list = [];
        foreach ($users as $user) {
            $role = $user->roles;
            $user->roles = $role;
            array_push($users_list, $user);
        }
        // dd($users_list);
        return view('layouts/admin-temp/users')->with('users', $users_list);
    }
}
