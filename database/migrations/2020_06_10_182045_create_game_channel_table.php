<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_channel', function (Blueprint $table) {
            $table->id();
            $table->integer('game_type_id');
            $table->string('name');
            $table->string('name_code');
            $table->string('cover_filename')->nullable();
            $table->string('slug');
            $table->string('uuid')->nullable();
            $table->integer('runtime')->default(5);
            $table->integer('gracetime')->default(1);
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
        Schema::dropIfExists('game_channel');
    }
}
