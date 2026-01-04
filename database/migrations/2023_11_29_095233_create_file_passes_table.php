<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_passes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('size')->nullable();
            $table->string('path')->nullable();
            $table->string('order_no')->nullable();
            $table->boolean('password_protected')->default(0);
            $table->string('password')->nullable();
            $table->string('qr_code')->nullable();
            $table->date('expiration_date');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_passes');
    }
}
