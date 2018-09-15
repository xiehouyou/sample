<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //用户添加一个 is_admin 的布尔值类型字段来判别用户是否拥有管理员身份，该字段默认为 false，在迁移文件执行时对该字段进行创建，回滚时则需要对该字段进行移除
             $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //回滚时对is——admin进行删除
            $table->dropColumn('is_admin');
        });
    }
}
