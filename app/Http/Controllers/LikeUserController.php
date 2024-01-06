<?php

namespace App\Http\Controllers;

use App\Events\SendLikeEvent;
use App\Events\StoreMessageEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeUserController extends Controller
{
    public function index(){

        $users=User::all();
        $user_id=Auth::user()->id;
        return view('users.index',['users'=>$users,'user_id'=>$user_id]);
    }


    public function like(Request $request){
        $data= $request->all();
        if($data['id']){
            $user_id=Auth::user()->id;
            $message="Пользователь с id".$user_id." поставил вам лайк";

            broadcast(new SendLikeEvent($message,$data['id']))->toOthers();

            return "success";
        }
    }
}
