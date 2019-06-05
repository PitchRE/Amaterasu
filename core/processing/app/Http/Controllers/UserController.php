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



    public function daily(Request $request)
    {



        $carbon = \Carbon\Carbon::now();


        $today = $carbon->format('Y-m-d H:i:s');

        $user = User::find($request->discord_id);

        $daily_train_before = $user->daily_train;

        $dateFromDatabase = strtotime($user->daily_date);
        $date24hoursAgo = strtotime("-24 hours");
        $date48hoursAgo = strtotime("-48 hours");

        if ($dateFromDatabase < $date48hoursAgo) {


            $cash_add = (500 / 100) * 20;
            $cash = 500 + $cash_add;

            $user->daily_train = 1;
            $user->daily_date = $today;
            $user->daily_cash = $cash;
            $user->increment('cash', $cash);
            $user->save();




            return response()->json(
                ['status' => 2, 'daily_cash' => $cash, 'daily_train' =>  $daily_train_before]
            );
        } else if ($dateFromDatabase >= $date24hoursAgo) {


            $Now = new \DateTime;

            $d = new \DateTime($user->daily_date);

            $test = $d->modify('+24 hour');

            $diff = $test->diff($Now);


            return response()->json(
                ['status' => -1, 'time' => $diff->format('%h hours, %i min')]
            );
        } else {


            $cash_add = ($user->daily_cash / 100) * 20;
            $cash = $user->daily_cash + $cash_add;

            $user->increment('daily_train');
            $user->daily_date = $today;
            $user->daily_cash = $cash;
            $user->increment('cash', $cash);
            $user->save();

            return response()->json(
                ['status' => 1, 'daily_cash' => $cash, 'daily_train' => $user->daily_train]
            );
        }
    }
}