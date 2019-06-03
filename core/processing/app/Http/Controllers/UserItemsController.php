<?php

namespace App\Http\Controllers;

use App\User_items;
use App\Items;
use Illuminate\Http\Request;

class UserItemsController extends Controller
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
    public function create(Request $request)
    {
        $RandItem = Items::inRandomOrder()->firstorFail();



        $user_item = new User_items;

        $user_item->discord_id = $request->discord_id;
        $user_item->item_id = $RandItem->id;
        $user_item->save();


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