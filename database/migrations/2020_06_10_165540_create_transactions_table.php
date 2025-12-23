<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('txnid')->nullable();
            $table->string('user_id');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 18,2);
            $table->integer('wallet_type')->comment('1 = cv, 2= pv');
            $table->integer('transaction_type_id');
            $table->enum('point_type', ['Type A', 'Type B', 'Type C'])->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status');
            $table->string('ip_address');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('ref_date');
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
        Schema::dropIfExists('transactions');
    }
}
