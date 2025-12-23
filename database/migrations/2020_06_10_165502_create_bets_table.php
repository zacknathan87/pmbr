<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id');
            $table->integer('game_type_id');
            $table->integer('bet_transaction_id');
            $table->integer('bet_type_id')->nullable();
            $table->string('bet_no')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('amount', 18, 2);
            $table->string('bet_ref')->nullable();
            $table->float('odd');
            $table->boolean('is_jackpot')->default(0);
            $table->boolean('is_win')->default(0);
            $table->boolean('is_fake')->default(0);
            $table->string('fake_username')->nullable();
            $table->decimal('win_amount', 18, 2)->default(0);
            $table->decimal('win_ratio', 18, 2)->default(0);
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
        Schema::dropIfExists('bets');
    }
}
