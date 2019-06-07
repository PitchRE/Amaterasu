<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function RecipeResult()
    {
        return $this->hasOne(Items::class, 'id', 'item_id');
    }

    public function item_1_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_1');
    }

    public function item_2_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_2');
    }
    public function item_3_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_3');
    }
    public function item_4_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_4');
    }
    public function item_5_data()
    {
        return $this->hasOne(Items::class, 'id', 'item_5');
    }
}