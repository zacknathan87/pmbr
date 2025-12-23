<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_room', function (Blueprint $table) {
            $table->id();
            $table->integer('game_type_id');
            $table->integer('game_channel_id');
            $table->string('name');
            $table->string('name_code');
            $table->string('slug');
            $table->string('cover_filename')->nullable();
            $table->string('uuid')->nullable();
            $table->integer('min_bet')->nullable();
            $table->string('bet_options')->nullable();
            $table->integer('min_balance')->nullable();
            $table->integer('max_balance')->nullable();
            $table->decimal('win_ratio', 18, 2)->nullable();
            $table->text('limit_data')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_room');
    }
}
