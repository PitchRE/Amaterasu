<?php

namespace App\Http\Controllers;

use App\Reputation;
use Illuminate\Http\Request;
use App\User;
use \Carbon\Carbon;

class ReputationController extends Controller
{





    public function rep(Request $request)
    {

        $user = User::find($request->discord_id);
        if ($user == null) {
            return response()->json(
                ['status' => -50]
            );
        }
        $Now = new \DateTime;
        $target = User::find($request->target_discord_id);

        $d = new \DateTime($user->Reputation->updated_at);


        if ($user->discord_id == $target->discord_id) {
            switch (strtotime($user->Reputation->updated_at) < strtotime('-1 hour')) {

                case true;

                    return response()->json(
                        ['status' => 3, 'points' => $target->Reputation->points, 'time' => -1]
                    );

                case false;

                    $test = $user->Reputation->updated_at->modify('+1 hour');

                    $now = Carbon::now();
                    $diff = $test->diffInMinutes($now);


                    return response()->json(
                        ['status' => 4, 'points' => $target->Reputation->points, 'time' => $diff]
                    );
            }
        }


        if ($user->Reputation->updated_at->timestamp < strtotime('-1 hour')) {

            $Rep = Reputation::find($target->discord_id);
            $Rep->timestamps = false;
            $Rep->increment('points');
            $Rep->save();

            Reputation::find($user->discord_id)->touch();

            return response()->json(
                ['status' => 2, 'points' => $target->Reputation->points, 'time' => -1]
            );
        } else {

            $test = $user->Reputation->updated_at->modify('+1 hour');

            $now = Carbon::now();
            $diff = $test->diffInMinutes($now);


            return response()->json(
                ['status' => -1, 'points' => $user->Reputation->points, 'time' => $diff]
            );
        }
    }
}