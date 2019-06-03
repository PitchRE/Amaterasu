<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\messages_log;

class UserController extends Controller
{
    public function check(Request $request)
    {
        if (User::where('discord_id', '=', $request->discord_id)->count() > 0) {


            $log = new messages_log;
            $log->discord_id = $request->discord_id;
            $log->nickname = $request->nickname;
            $log->guild_id = $request->guild_id;
            $log->guild_name = $request->guild_name;
            $log->channel_id = $request->channel_id;
            $log->channel_name = $request->channel_name;
            $log->content = $request->content;
            $log->save();

            return '1';
        } else {

            $discordid = $request->discord_id;

            $user = new User;

            $user->discord_id = $discordid;

            $user->name = $request->name;
            $user->password = Hash::make('test');

            $user->save();

            return '2';
        }
    }
}