<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 6; $i++) {
            DB::table('positions')->insert([
                'name' => "G{$i}",
            ]);
        }
    }
}
