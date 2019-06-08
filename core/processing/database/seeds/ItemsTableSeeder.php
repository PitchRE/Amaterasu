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
            'rarity' => 'Common',
            'value' => 500,
            'image' => '🍬',

        ]);

        DB::table('items')->insert([
            'name' => 'Jelly',
            'rarity' => 'Common',
            'value' => 500,
            'image' => '🍓',

        ]);

        DB::table('items')->insert([
            'name' => 'The Story Begins',
            'rarity' => 'Uncommon',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TheStoryBegins.jpg',

        ]);

        DB::table('items')->insert([
            'name' => 'PAGE TWO',
            'rarity' => 'Rare',
            'value' => 500,
            'image' => 'storage/TWICE/albums/PAGETWO.jpg',

        ]);



        DB::table('items')->insert([
            'name' => 'Twicecoaster：lane1',
            'rarity' => 'Rare',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TWICEcoaster_LANE_1.jpg',

        ]);


        DB::table('items')->insert([
            'name' => 'Twicecoaster：Lane 2',
            'rarity' => 'Epic',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TWICEcoaster_LANE_2.jpg',

        ]);

        DB::table('items')->insert([
            'name' => 'Cookie Jar',
            'rarity' => 'Common',
            'value' => 500,
            'image' => 'storage/TWICE/albums/TWICEcoaster_LANE_2.jpg',
            'dropable' => false,
        ]);
    }
}