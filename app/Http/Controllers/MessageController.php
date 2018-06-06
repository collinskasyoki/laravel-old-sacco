<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(){
        $this->settings = \App\Setting::all()->first();
    }

    public function broadcast(){
        if($this->settings->notifications){
            $members = \App\Member::all();
            $message = \Input::get('message');

            foreach($members as $member){
                \App\NotifySend::create(['messageto'=>$member->phone, 'messagefrom'=>$this->settings->notification_number, 'member_id'=>$member->id, 'message'=>$message]);
            }

            return response()->json('sending', 200);
        }else{
            return response()->json('notifications off', 200);
        }
    }
}
