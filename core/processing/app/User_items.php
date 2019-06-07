<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_items extends Model
{

    protected $fillable = [
        'discord_id', 'item_id',
    ];

    public function item_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_id');
    }
}