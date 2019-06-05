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


    public function sell(Request $request)
    {

        $ammount = $request->ammount;

        // return response()->json(["id" => $request->discord_id, 'item' => $request->item_name, 'ammount' => $request->ammount], 201);

        if ($ammount == 'all' && $request->item_name == 'all') {

            $item_to_sell = User_items::where('discord_id', $request->discord_id)->get();



            $allCash = 0;
            $itemNum = 0;
            $SoldedArray = collect([]);
            foreach ($item_to_sell as $item) {

                if ($item->count < 1) continue;
                $allCash += $item->item_data->value * $item->count;
                $itemNum += $item->count;


                $SoldedArray->put($item->item_data->name, $item->count);


                $item->decrement('count', $item->count);
                $item->save();
            }

            $usr = User::find($request->discord_id);
            $usr->increment('cash', $allCash);
            $usr->save();

            return response()->json(["status" => 3, 'cash' => $allCash, 'balance' => $usr->cash, 'ammount' => $itemNum, 'itemCollection' => $SoldedArray], 201);
        } {


            $item_to_sell = User_items::whereHas('item_data', function ($q) use ($request) {
                $q->where('name', '=', $request->item_name);
            })->where('discord_id', $request->discord_id)->first();



            if ($item_to_sell == null) return response()->json(["status" => -2, 'item' => $request->item_name], 201);
            if ($request->ammount == 'all') $ammount = $item_to_sell->count;
            if ($ammount > $item_to_sell->count) return response()->json(["status" => -1, 'item' => $item_to_sell->item_data->name, 'ammountleft' => $item_to_sell->count, 'ammount' => $ammount], 201);


            $cash = $ammount * $item_to_sell->item_data->value;


            $item_to_sell->decrement('count', $ammount);
            $item_to_sell->save();

            $usr = User::find($request->discord_id);
            $usr->increment('cash', $cash);
            $usr->save();


            return response()->json(["status" => 1, 'cash' => $cash, 'balance' => $usr->cash, 'ammountleft' => $item_to_sell->count, 'ammount' => $ammount, 'item' => $item_to_sell->item_data->name], 201);
        }
    }
}