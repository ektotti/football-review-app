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
        $users = factory(App\User::class, 30)
        ->create()
        ->each(function ($user){
            $user->posts()->createMany(factory(App\Post::class, 2)
            ->make(["user_id" => $user->id])->toArray());
        });
    }
}
