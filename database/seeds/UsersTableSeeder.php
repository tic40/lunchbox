<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        for ($i = 1; $i <= 10; $i++) {
            $employees[] = [
                'name' => "test{$i}",
                'email' => "test{$i}@example.com",
                'password' => bcrypt("test{$i}"),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('users')->insert($employees);
    }
}
