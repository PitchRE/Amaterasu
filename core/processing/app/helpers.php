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

//     $rand = rand(1, 100);   
//     if ($rand <= 50) { 
//         $rarity = 'common';
//     } else if ($rand <= 80) {
//         $rarity = 'uncommon';
//     } else {
//         $rarity = 'rare';
//     }

//     return $rarity;
// }