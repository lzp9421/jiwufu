<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $this->engine = 'Innodb';
            $table->increments('id');
            $table->string('wechat_id', 255)->default('')->comment('微信OpenId');
            $table->string('name', 50)->default('')->comment('用户名');
            $table->string('nickname', 50)->default('')->comment('用户名');
            $table->string('avatar', 255)->default('')->comment('头像');
            $table->string('email', 100)->default('')->comment('email');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedInteger('create_time')->default(0);
            $table->unsignedInteger('update_time')->default(0);

            $table->index('wechat_id', 'idx_wechat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
