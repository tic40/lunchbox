<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $now = new Carbon\Carbon();
        $dt = $now->copy()->subMonth(2);

        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                DB::table('groups')->insert([
                    'name' => $faker->firstNameMale,
                    'target_date' => $dt->firstOfMonth(),
                ]);
            }
            $dt->addMonth();
        }
    }
}
