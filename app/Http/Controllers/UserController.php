<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\UserCreate;

class UserController extends Controller
{
    public function showListUser(){
        $users = User::get();
        return view('users/showUsers')->with([
            'users' => $users
        ]);
    }
    public function postAddUser(Request $req)  {
        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'image' => $req->image,
            'password' => Hash::make('password')
        ];
        $user = User::create($data);
        broadcast(new UserCreate($user));
        return json_encode([
            'success' => 'done'
        ]);
    }

    public function postDetalUser(Request $req){
        $user = User::select('name', 'email', 'image')->find($req->id);
        return json_encode($user);
    }
    public function postUpdateUser(Request $req){
        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'image' => $req->image
        ];
        User::where('id', $req->id)->update($data);
        return json_encode([
            'success' => 'done'
        ]);
    }
    public function postDeleteUser(Request $req){
        User::where('id', $req->id)->delete();
        return json_encode([
            'success' => 'done'
        ]);
    }
}
