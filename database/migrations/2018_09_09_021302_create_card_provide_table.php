<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardProvideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_provide', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('card_id')->default(0)->comment('卡片ID');
            $table->unsignedInteger('day')->default(0);
            $table->unsignedInteger('num')->default(0)->comment('数量');
            $table->unsignedInteger('create_time')->default(0);
            $table->unsignedInteger('update_time')->default(0);
            $table->index('day', 'idx_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_provide');
    }
}
