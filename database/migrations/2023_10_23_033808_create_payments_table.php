<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_no')->nullable();
            $table->unsignedBigInteger('virtual_machiene_id')->nullable();
            $table->unsignedBigInteger('operating_system_id')->nullable();
            $table->integer('period')->nullable();
            $table->string('amount')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('vm_location')->nullable();
            $table->string('vpn_location')->nullable();
            $table->date('expiry_date');
            $table->string('currency')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('virtual_machiene_id')->references('id')->on('virtual_machienes')->onDelete('cascade');
            $table->foreign('operating_system_id')->references('id')->on('operating_systems')->onDelete('cascade');
  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
