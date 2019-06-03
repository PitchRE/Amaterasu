<?php

namespace App\Http\Controllers;

use App\Reputation;
use Illuminate\Http\Request;
use App\User;
use \Carbon\Carbon;

class ReputationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reputation  $reputation
     * @return \Illuminate\Http\Response
     */
    public function show(Reputation $reputation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reputation  $reputation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reputation $reputation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reputation  $reputation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reputation $reputation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reputation  $reputation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reputation $reputation)
    {
        //
    }


    public function rep(Request $request)
    {

        $user = User::find($request->discord_id);
        $Now = new \DateTime;

        $d = new \DateTime($user->Reputation->updated_at);


        if (strtotime($user->Reputation->updated_at) < strtotime('-1 hour')) {

            Reputation::find($user->discord_id)->increment('points');

            return response()->json(
                ['status' => 2, 'points' => $user->Reputation->points, 'time' => -1]
            );
        } else {
            $test = $user->Reputation->updated_at->modify('+1 hour');

            $now = Carbon::now();
            $diff = $test->diffInMinutes($now);
            return response()->json(
                ['status' => -1, 'points' => $user->Reputation->points, 'time' => $diff]
            );
        }

        return 1;
    }
}