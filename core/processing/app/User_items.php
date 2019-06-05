<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_items extends Model
{
    public function item_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_id');
    }
}