<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory (User::class) -> times (50)->make ();

        User::insert($user->makeVisible(['password', 'remember_token'])->toArray());

        $user = \App\Models\User::find(1);

        $user->name = "Jean";
        $user->email = "245908530@qq.com";
        $user->password = bcrypt('123456');
        $user->is_admin = true;
        $user->activated = true;

        $user->save();
    }
}
