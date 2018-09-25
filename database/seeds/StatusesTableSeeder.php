<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;
class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //我们不需要为每个用户都生成大量微博，为了测试方便且提高假数据的生成速度，我们只为前三个用户生成共 100 条微博假数据。
         $user_ids = ['1','2','3'];
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)->times(100)->make()->each(function ($status) use ($faker, $user_ids) {
            $status->user_id = $faker->randomElement($user_ids);
        });

        Status::insert($statuses->toArray());
    }
}
