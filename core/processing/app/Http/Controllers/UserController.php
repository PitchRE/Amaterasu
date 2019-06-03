<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function check(Request $request)
    {
        if (User::where('discord_id', '=', $request->discord_id)->count() > 0) {
            return '1';
        } else {
            $User = new User;
            $User->discord_id = $request->discord_id;
            $User->name = $request->name;
            $User->password = Hash::make('test');
            $User->save();
            return '2';
        }
    }
}