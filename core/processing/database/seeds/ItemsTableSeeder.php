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
            'name' => 'Candy',
            'rarity' => 'nice',
            'value' => 500,
            'image' => '🍬',
            'color' => '#3160ed'
        ]);

        DB::table('items')->insert([
            'name' => 'Jelly',
            'rarity' => 'nice',
            'value' => 500,
            'image' => '🍓',
            'color' => '#3160ed'
        ]);

        DB::table('items')->insert([
            'name' => 'The Story Begins',
            'rarity' => 'good',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TheStoryBegins.jpg',
            'color' => '#3160ed'
        ]);

        DB::table('items')->insert([
            'name' => 'PAGE TWO',
            'rarity' => 'good',
            'value' => 500,
            'image' => 'storage/TWICE/albums/PAGETWO.jpg',
            'color' => '#3160ed'
        ]);



        DB::table('items')->insert([
            'name' => 'Twicecoaster：lane1',
            'rarity' => 'good',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TWICEcoaster_LANE_1.jpg',
            'color' => '#3160ed'
        ]);


        DB::table('items')->insert([
            'name' => 'Twicecoaster：Lane 2',
            'rarity' => 'good',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TWICEcoaster_LANE_2.jpg',
            'color' => '#3160ed'
        ]);
    }
}