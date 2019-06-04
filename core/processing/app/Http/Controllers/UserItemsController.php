<?php

namespace App\Http\Controllers;

use App\User_items;
use App\Items;
use App\User;
use Illuminate\Http\Request;

class UserItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find($request->discord_id);

        // return $user->user_items;


        return response()->json(["DATA" => $user->user_items->load('item_data')->toArray()], 201);

        $user_items = $user->user_items;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $RandItem = Items::inRandomOrder()->firstorFail();

        if (User_items::where('discord_id', $request->discord_id)->where('item_id', $RandItem->id)->count() > 0) {
            // user found

            User_items::where('discord_id', $request->discord_id)->where('item_id', $RandItem->id)->first()->increment('count');
        } else {

            $user_item = new User_items;

            $user_item->discord_id = $request->discord_id;
            $user_item->item_id = $RandItem->id;
            $user_item->save();
        }

        return $RandItem;
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
     * @param  \App\User_items  $user_items
     * @return \Illuminate\Http\Response
     */
    public function show(User_items $user_items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_items  $user_items
     * @return \Illuminate\Http\Response
     */
    public function edit(User_items $user_items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_items  $user_items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_items $user_items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_items  $user_items
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_items $user_items)
    {
        //
    }
}