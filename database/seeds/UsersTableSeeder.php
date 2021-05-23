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
      DB::table('users')->truncate();

      DB::table('users')->insert([
        'name' => 'MarkMakesStuff',
        'email' => 'arenz.mark@gmail.com',
        'role' => 'admin',
        'password' => bcrypt('J3jH2ks2_g1kJ6')
      ]);
    }
}
