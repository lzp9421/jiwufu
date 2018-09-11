<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card', function (Blueprint $table) {
            $this->engine = 'Innodb';
            $table->increments('id');
            $table->string('name', 50)->default('')->comment('卡片标识');
            $table->unsignedTinyInteger('type')->default(0)->comment('卡片类型：0 一般卡片，1 五福卡片');
            $table->string('title', 50)->default('')->comment('卡片名');
            $table->string('description', 255)->default('')->comment('卡片说明');
            $table->string('image', 255)->default('')->comment('卡片图片');
            $table->string('thumb', 255)->default('')->comment('卡片小图');
            $table->unsignedInteger('create_time')->default(0);
            $table->unsignedInteger('update_time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card');
    }
}
