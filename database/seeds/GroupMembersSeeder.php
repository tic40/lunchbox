<?php

use Illuminate\Database\Seeder;

class GroupMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                for ($k = 1; $k <= 5; $k++) {
                    DB::table('group_members')->insert([
                        'group_id' => $j + ($i-1) * 10,
                        'employee_id' => $k + ($j-1) * 5,
                        'is_leader' => $k == 1 ? 1 : 0,
                    ]);
                }
            }
        }
    }
}
