<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardGivenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_given', function (Blueprint $table) {
            $this->engine = 'Innodb';
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0)->comment('用户ID');
            $table->unsignedInteger('card_id')->default(0)->comment('卡片ID');
            $table->unsignedInteger('to_user_id')->default(0)->comment('领取用户ID');
            $table->string('token', 100)->default(0)->comment('领取秘钥');
            $table->unsignedTinyInteger('status')->default(0)->comment('赠送状态');
            $table->unsignedInteger('create_time')->default(0); // 赠送时间
            $table->unsignedInteger('update_time')->default(0); // 领取时间

            $table->index(['user_id', 'card_id'], 'idx_user_card');
            $table->index('to_user_id', 'idx_to_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_given');
    }
}
