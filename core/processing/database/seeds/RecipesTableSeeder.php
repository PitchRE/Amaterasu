<?php

use Illuminate\Database\Seeder;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('recipes')->insert([
            'name' => 'Cookie Jar',
            'item_id' => 7,
            'item_1' => 1,
            'item_2' => 2,
        ]);
    }
}