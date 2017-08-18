<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user=new User;
        $user->name='Mujiono';
        $user->email='mujiono5@gmail.com';
        $user->password=bcrypt('welcome');
        $user->level='admin';
        $user->save();
    }
}
