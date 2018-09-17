<?php

/*use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    *
     * Run the database seeds.
     *
     * @return void
     
    public function run()
    {
        //
    }
}
*/
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'Aufree';
        $user->email = 'aufree@yousails.com';
        $user->password = bcrypt('password');
        //将生成的第一个用户设置为管理员
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}