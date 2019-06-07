<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\User;
use App\User_items;
use App\Items;
use Illuminate\Http\Request;

class RecipeController extends Controller
{

    public function make(Request $request)
    {

        $user_items = User_items::where('discord_id', $request->discord_id);


        $missing = array();


        $recipe = Recipe::whereHas('RecipeResult', function ($q) use ($request) {
            $q->where('name', $request->item_name);
        })->first();



        $item_1_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_1)->where('count', '>', 0)->first();
        $item_2_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_2)->where('count', '>', 0)->first();
        $item_3_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_3)->where('count', '>', 0)->first();
        $item_4_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_4)->where('count', '>', 0)->first();
        $item_5_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_5)->where('count', '>', 0)->first();


        if ($recipe->item_1 == null) $item_1_res = 'ignore';
        if ($recipe->item_2 == null) $item_2_res = 'ignore';
        if ($recipe->item_3 == null) $item_3_res = 'ignore';
        if ($recipe->item_4 == null) $item_4_res = 'ignore';
        if ($recipe->item_5 == null) $item_5_res = 'ignore';

        if ($item_1_res == null) array_push($missing, $recipe->item_1_data->name);
        if ($item_2_res == null) array_push($missing, $recipe->item_2_data->name);
        if ($item_3_res == null) array_push($missing, $recipe->item_3_data->name);
        if ($item_4_res == null) array_push($missing, $recipe->item_4_data->name);
        if ($item_5_res == null) array_push($missing, $recipe->item_5_data->name);




        if (empty($missing)) {

            if ($item_1_res != 'ignore')  $item_1_res->decrement('count');
            if ($item_2_res != 'ignore')  $item_2_res->decrement('count');
            if ($item_3_res != 'ignore')  $item_3_res->decrement('count');
            if ($item_4_res != 'ignore')  $item_4_res->decrement('count');
            if ($item_5_res != 'ignore')  $item_5_res->decrement('count');



            $res = User_items::firstOrCreate(['discord_id' => $request->discord_id, 'item_id' => $recipe->item_id]);

            if (!$res->wasRecentlyCreated) $res->increment('count');

            return response()->json(["status" => 1, 'item_name' => $res->item_data->name], 201);
        }
        return response()->json(["status" => -1, 'missing' => $missing], 201);
    }



    public function available(Request $request)
    {
        $canMake = array();

        $Recipes = Recipe::all();


        foreach ($Recipes as $recipe) {

            $item_1_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_1)->where('count', '>', 0)->first();
            $item_2_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_2)->where('count', '>', 0)->first();
            $item_3_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_3)->where('count', '>', 0)->first();
            $item_4_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_4)->where('count', '>', 0)->first();
            $item_5_res = User_items::where('discord_id', $request->discord_id)->where('item_id', $recipe->item_5)->where('count', '>', 0)->first();


            if ($recipe->item_1 == null) $item_1_res = 'ignore';
            if ($recipe->item_2 == null) $item_2_res = 'ignore';
            if ($recipe->item_3 == null) $item_3_res = 'ignore';
            if ($recipe->item_4 == null) $item_4_res = 'ignore';
            if ($recipe->item_5 == null) $item_5_res = 'ignore';

            if ($item_1_res != null && $item_2_res != null && $item_3_res != null && $item_4_res != null && $item_5_res != null) array_push($canMake, $recipe->RecipeResult->name);
        }

        if (empty($canMake)) {
            return response()->json(["status" => -1], 201);
        } else {
            return response()->json(["status" => 1, 'canMake' => $canMake], 201);
        }
    }


    public function all(Request $request)
    {



        $Recipes = Recipe::with('RecipeResult')->get()->pluck('RecipeResult.name');


        return response()->json(["status" => 1, 'recipes' => $Recipes], 201);
    }
}