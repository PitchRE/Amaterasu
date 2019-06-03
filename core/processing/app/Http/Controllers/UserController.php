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

            generate_log($request);


            return '1';
        } else {

            $discordid = $request->discord_id;

            $user = new User;

            $user->discord_id = $discordid;

            $user->name = $request->name;
            $user->password = Hash::make('test');

            $user->save();

            generate_log($request);

            return '2';
        }
    }
}