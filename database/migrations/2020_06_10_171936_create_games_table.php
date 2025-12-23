<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('game_type_id');
            $table->integer('game_channel_id');
            $table->integer('status_id')->comment('1-pending, 2-active, 3-waiting result, 4-ended');
            $table->integer('result_no')->nullable();
            $table->text('no')->nullable();
            // $table->integer('dice_1')->nullable();
            // $table->integer('dice_2')->nullable();
            // $table->integer('dice_3')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE games AUTO_INCREMENT = 1000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
