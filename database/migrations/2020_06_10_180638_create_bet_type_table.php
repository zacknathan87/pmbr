<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_type', function (Blueprint $table) {
            $table->id();
            $table->string('bet_type_group_id');
            $table->string('name');
            $table->string('name_code');
            $table->string('value');
            $table->float('odd');
            $table->enum('type', ['range', 'number']);
            $table->boolean('final_no')->default(0);
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
        Schema::dropIfExists('bet_type');
    }
}
