<?php

namespace App\Http\Controllers;

use App\UserSkill;
use Illuminate\Http\Request;
use App\User;

class UserSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find($request->discord_id);
        if ($user == null)   return response()->json(["status" => -50,], 201);
        $skill = UserSkill::find($request->discord_id);


        $luck_bolean = false;


        if ($user->cash >= $skill->luck_price) $luck_bolean = true;


        return response()->json(["status" => 1, 'luck' => $user->user_skills->luck, 'luck_price' => $user->user_skills->luck_price, 'luck_bolean' => $luck_bolean, 'balance' => $user->cash], 201);
    }


    public function buy(Request $request)
    {
        $user = User::find($request->discord_id);
        if ($user == null)   return response()->json(["status" => -50,], 201);
        $skill = UserSkill::find($request->discord_id);

        switch ($request->skill_name) {
            case 'Luck':

                if ($skill->luck_price >  $user->cash) return response()->json(["status" => -1,], 201);
                $val1 = $user->user_skills->luck_price;
                $val1 = ($val1 / 100) * 30;
                $user->decrement('cash', $skill->luck_price);
                $skill->increment('luck');
                $skill->increment('luck_price', $val1);
                return response()->json(["status" => 1, 'level' => $skill->luck, 'price' => $skill->luck_price, 'name' => $request->skill_name], 201);
                break;
            default:
                return response()->json(["status" => -2], 201);

                break;
        }
    }
}