<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
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

        for ($i = 1; $i <= 100; $i++) {
            DB::table('employees')->insert([
                'name' => $faker->firstNameMale,
                'department_id' => $faker->numberBetween($min = 1, $max = 15),
                'position_id' => $faker->numberBetween($min = 1, $max = 6),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
