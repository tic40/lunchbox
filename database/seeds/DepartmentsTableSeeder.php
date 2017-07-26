<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $now = \Carbon\Carbon::now();

        for ($i = 1; $i <= 15; $i++) {
            DB::table('departments')->insert([
                'name' => $faker->unique()->colorName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
