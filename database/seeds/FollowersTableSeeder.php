<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用第一个用户对除自己以外的用户进行关注，接着再让所有用户去关注第一个用户
        $users=User::all();
        $user=$users->first();
        $user_id=$user->id;

        /*获取除去ID为1的所有用户的ID数组*/
        $followers=$users->slice(1);
        $follower_ids=$followers->pluck('id')->toArray();
     	
     	/*关注除1号用户以外的所有用户*/
     	$user->follow($follower_ids);

     	/*除1号用户以外的所有人都来关注1号用户*/
     	foreach ($followers as $follower) {
     		# code...
     		$follower->follow($user_id);
     	}
    }
}
