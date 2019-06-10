<?php

namespace App\Http\Controllers;

use App\User_items;
use App\Items;
use App\User;
use Illuminate\Http\Request;

class UserItemsController extends Controller
{
    /**
     * LIST USER ITEMS/BACKPACK
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find($request->discord_id);

        // return $user->user_items;

        if ($user == null) {
            return response()->json(
                ['status' => -50]
            );
        }


        $worth = 0;

        foreach ($user->user_items as $item) {
            $worth += $item->count * $item->item_data->value;
        }


        return response()->json(["status" => 1, "DATA" => $user->user_items->load('item_data')->toArray(), 'value' => $worth], 201);

        $user_items = $user->user_items;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 
    // 
    // 
    // 
    // 
    // 
    // 
    // 
    // 
    // 



    public function create(Request $request)
    {


        $user = User::find($request->discord_id);
        $RandItem = Items::Where('rarity', rarity($user))->Where('dropable', true)->inRandomOrder()->firstorFail();


        if (User_items::where('discord_id', $request->discord_id)->where('item_id', $RandItem->id)->first() != null) {


            User_items::where('discord_id', $request->discord_id)->where('item_id', $RandItem->id)->first()->increment('count');
        } else {

            $user_item = new User_items;

            $user_item->discord_id = $request->discord_id;
            $user_item->item_id = $RandItem->id;
            $user_item->increment('count');
            $user_item->save();
        }

        $user_item = User_items::where('discord_id', $request->discord_id)->where('item_id', $RandItem->id)->first();



        return response()->json(["status" => 1, 'name' => $RandItem->name, 'rarity' => $RandItem->rarity, 'image' => $RandItem->image, 'count' => $user_item->count], 201);
    }



    /**
     * 
     * SELL
     * 
     * 
     */


    public function sell(Request $request)
    {

        $user = User::find($request->discord_id);

        // return $user->user_items;

        if ($user == null) {
            return response()->json(
                ['status' => -50]
            );
        }
        $ammount = $request->ammount;

        // return response()->json(["id" => $request->discord_id, 'item' => $request->item_name, 'ammount' => $request->ammount], 201);

        $rarity_array = array('common', 'uncommon', 'rare', 'epic', 'legendary');

        if (in_array($request->item_name, $rarity_array)) {


            if ($request->ammount != 'all') {

                $item_to_sell = User_items::whereHas('item_data', function ($q) use ($request) {
                    $q->where('rarity', '=', $request->item_name);
                })->where('discord_id', $request->discord_id)->where('count', '>=', $request->ammount)->get();

                $allCash = 0;
                $itemNum = 0;
                $SoldedArray = collect([]);
                foreach ($item_to_sell as $item) {

                    if ($item->count < $request->ammount) continue;
                    $allCash += $item->item_data->value * $request->ammount;
                    $itemNum += $request->ammount;


                    $SoldedArray->put($item->item_data->name, $request->ammount);


                    $item->decrement('count', $request->ammount);
                    $item->save();
                }

                $usr = User::find($request->discord_id);
                $usr->increment('cash', $allCash);
                $usr->save();

                return response()->json(["status" => 3, 'cash' => $allCash, 'balance' => $usr->cash, 'ammount' => $itemNum, 'itemCollection' => $SoldedArray], 201);
            } else {

                $item_to_sell = User_items::whereHas('item_data', function ($q) use ($request) {
                    $q->where('rarity', '=', $request->item_name);
                })->where('discord_id', $request->discord_id)->get();

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
            }
        } else if ($request->item_name == 'all') {


            if ($request->ammount != 'all') {

                $item_to_sell = User_items::where('discord_id', $request->discord_id)->where('count', '>=', $request->ammount)->get();

                $allCash = 0;
                $itemNum = 0;
                $SoldedArray = collect([]);
                foreach ($item_to_sell as $item) {

                    if ($item->count < $request->ammount) continue;
                    $allCash += $item->item_data->value * $request->ammount;
                    $itemNum += $request->ammount;


                    $SoldedArray->put($item->item_data->name, $request->ammount);


                    $item->decrement('count', $request->ammount);
                    $item->save();
                }

                $usr = User::find($request->discord_id);
                $usr->increment('cash', $allCash);
                $usr->save();

                return response()->json(["status" => 3, 'cash' => $allCash, 'balance' => $usr->cash, 'ammount' => $itemNum, 'itemCollection' => $SoldedArray], 201);
            } else {
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
            }
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

    /**
     * 
     *  GIVE ITEM/ITEMS
     * 
     */


    public function give(Request $request)
    {

        $user = User::find($request->discord_id);

        // return $user->user_items;



        $owner = User::find($request->discord_id);
        $target = User::find($request->target_discord_id);

        if ($owner == null || $target == null)   return response()->json(["status" => -50], 201); /// No account

        $item_to_give = User_items::whereHas('item_data', function ($q) use ($request) {
            $q->where('name', '=', $request->item_name);
        })->where('discord_id', $request->discord_id)->where('count', '>=', $request->ammount)->first();

        if ($item_to_give == null)   return response()->json(["status" => -2], 201); /// Not enought items.

        $item_to_give->decrement('count', $request->ammount);


        $to_give = User_items::whereHas('item_data', function ($q) use ($request) {
            $q->where('name', '=', $request->item_name);
        })->where('discord_id', $request->target_discord_id)->first();

        if ($to_give != null) {
            $to_give->increment('count', $request->ammount);
            $to_give->save();

            return response()->json(["status" => 1, 'ammount' => $request->ammount, 'item_name' => $item_to_give->item_data->name], 201); ///item exist, increase . 
        } else {
            $new = new User_items;
            $new->discord_id = $request->target_discord_id;
            $new->count = $request->ammount;
            $new->item_id = $item_to_give->item_id;
            $new->save();
            return response()->json(["status" => 2, 'ammount' => $request->ammount, 'item_name' => $item_to_give->item_data->name], 201); /// No item, increase . Achiv
        }
    }
}