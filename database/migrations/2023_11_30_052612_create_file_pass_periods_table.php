<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePassPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_pass_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('period_value')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('storage_bytes')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Adjust precision and scale as needed
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
        Schema::dropIfExists('file_pass_periods');
    }
}
