<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){

        $message=Message::latest()->get();

        return view('message.index',['messages'=>$message]);
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

        return response()->json($message);
    }


}
