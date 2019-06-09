<?php
use App\messages_log;

function generate_log($request)
{
    if ($request->bot) return;
    if ($request->content == null) return;
    $log = new messages_log;
    $log->discord_id = $request->discord_id;
    $log->nickname = $request->nickname;
    $log->guild_id = $request->guild_id;
    $log->guild_name = $request->guild_name;
    $log->channel_id = $request->channel_id;
    $log->channel_name = $request->channel_name;
    $log->content = $request->content;
    $log->save();
}


// function rarity_algorithm()
// {

//     $rand = rand(1, 1000);   
//     if ($rand <= 500) { 
//         $rarity = 'common';
//     } else if ($rand <= 0) {
//         $rarity = 'uncommon';
//     } else {
//         $rarity = 'rare';
//     }

//     return $rarity;
// }



function rarity($user)
{

    $common = 500;
    $uncommon = 250;
    $rare = 150;
    $epic = 80;
    $legendary = 20;

    $user_skill_level = $user->user_skills->luck;


    /**
     * 
     * Above values will be loaded from database. 
     * So you can change them for events etc.
     * 
     * 
     */

    for ($i = 0; $i < $user_skill_level; $i++) {


        if ($rare < 250) $rare += 1.2;
        if ($epic < 180) $epic += 0.7;
        if ($legendary < 140) $legendary += 0.3;
    }

    /**
     * Above part is for hardcoding limit.
     * We want to avoid situation where u can't no more draw common quality/rarity item.
     */


    $chance = array();


    for ($i = 0; $i < $common; $i++) {
        array_push($chance, "common");
    }

    for ($i = 0; $i < $uncommon; $i++) {
        array_push($chance, "uncommon");
    }

    for ($i = 0; $i < $rare; $i++) {
        array_push($chance, "rare");
    }

    for ($i = 0; $i < $epic; $i++) {
        array_push($chance, "epic");
    }

    for ($i = 0; $i < $legendary; $i++) {
        array_push($chance, "legendary");
    }

    /**
     * Bellow part only for testing purposes
     */

    // $myObj = new stdClass();
    // $myObj->result = $chance[array_rand($chance)];
    // $myObj->count = count($chance);
    // $myObj->common = $common;
    // $myObj->uncommon = $uncommon;
    // $myObj->rare = $rare;
    // $myObj->epic = $epic;
    // $myObj->legendary = $legendary;

    // $myJSON = json_encode($myObj);



    // $c1 = 0;
    // $c2 = 0;
    // $c3 = 0;
    // $c4 = 0;
    // $c5 = 0;
    // for ($i = 0; $i < 1000; $i++) {

    //     if ($chance[array_rand($chance)] == 'common') $c1++;
    //     if ($chance[array_rand($chance)] == 'uncommon') $c2++;
    //     if ($chance[array_rand($chance)] == 'rare') $c3++;
    //     if ($chance[array_rand($chance)] == 'very rare') $c4++;
    //     if ($chance[array_rand($chance)] == 'legendary') $c5++;
    // }

    // return response()->json(["common" => $c1, "uncommon" => $c2, "rare" => $c3, "very rare" => $c4, "legendary" => $c5,], 201);

    return $chance[array_rand($chance)];
}


function chances($user)
{

    $common = 500;
    $uncommon = 250;
    $rare = 150;
    $epic = 80;
    $legendary = 20;

    $user_skill_level = $user->user_skills->luck;


    /**
     * 
     * Above values will be loaded from database. 
     * So you can change them for events etc.
     * 
     * 
     */

    for ($i = 0; $i < $user_skill_level; $i++) {


        if ($rare < 250) $rare += 1.2;
        if ($epic < 180) $epic += 0.7;
        if ($legendary < 140) $legendary += 0.3;
    }

    /**
     * Above part is for hardcoding limit.
     * We want to avoid situation where u can't no more draw common quality/rarity item.
     */


    $chance = array();


    for ($i = 0; $i < $common; $i++) {
        array_push($chance, "common");
    }

    for ($i = 0; $i < $uncommon; $i++) {
        array_push($chance, "uncommon");
    }

    for ($i = 0; $i < $rare; $i++) {
        array_push($chance, "rare");
    }

    for ($i = 0; $i < $epic; $i++) {
        array_push($chance, "epic");
    }

    for ($i = 0; $i < $legendary; $i++) {
        array_push($chance, "legendary");
    }

    $count = count($chance);

    $myObj = new stdClass();
    $myObj->common = number_format(($common / $count) * 100, 2);
    $myObj->uncommon = number_format(($uncommon / $count) * 100, 2);
    $myObj->rare = number_format(($rare / $count) * 100, 2);
    $myObj->epic = number_format(($epic / $count) * 100, 2);
    $myObj->legendary = number_format(($legendary / $count) * 100, 2);
    $myObj->luck = $user->user_skills->luck;

    return $myObj;
}