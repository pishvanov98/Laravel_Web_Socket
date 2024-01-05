<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(){

        $message=Message::latest()->get();
        $user_id=Auth::user()->id;
        return view('message.index',['messages'=>$message,'user'=>$user_id]);
    }

    public function store(Request $request){

        $data=$request->validate([
         'message' => ['required']
        ]);
        $message= new Message();
        $message->body=$data['message'];
        $message->save();


        $current = Carbon::now();

        $message->time=$current->format('Y-m-d H:i:s');
        $user_id=Auth::user()->id;

        //event(new StoreMessageEvent($message,$message->time)); отправляет всем
        broadcast(new StoreMessageEvent($message,$message->time,$user_id))->toOthers();// отправка всем кроме текущего пользователя,
        //у меня не сработало, пришлось отправлять id пользователя что бы определить на фронтенде где не выводить инф.

        return response()->json($message);
    }


}
