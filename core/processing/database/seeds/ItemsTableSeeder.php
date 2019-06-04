<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Yoinked from: https://github.com/esfox/TWICE-Station/blob/refactor/data/items.json
         */


        DB::table('items')->insert([
            'name' => 'candy',
            'rarity' => 'common',
            'value' => 500,
            'image' => 'https://cdn.shopify.com/s/files/1/0636/4053/products/sticker_800x.png?v=1487531730',
            'color' => '#3160ed'
        ]);
    }
}