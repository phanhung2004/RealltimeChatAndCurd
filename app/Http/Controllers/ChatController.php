<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserOnline;

class ChatController extends Controller
{
    //
    public function chat(){
        $user = User::where('id', '<>', Auth::user()->id)->get();
        return view('chat/chatpublic')->with([
            'users' => $user
        ]);
    }

    public function sent(Request $req)  {
        broadcast(new UserOnline($req->user(), $req->message, $req->image));
        return json_encode([
            "success" => 'done'
            
        ]);
    }
}
