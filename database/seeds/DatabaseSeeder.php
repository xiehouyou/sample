<?php

/*use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    *
     * Run the database seeds.
     *
     * @return void
     
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    }
}
*/
//接着我们还需要在 DatabaseSeeder 中调用 call 方法来指定我们要运行假数据填充的文件。
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);

        Model::reguard();
    }
}