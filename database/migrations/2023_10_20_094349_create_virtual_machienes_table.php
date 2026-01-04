<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualMachienesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_machienes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();    
            $table->string('cpu')->nullable();     
            $table->string('ram')->nullable();      
            $table->string('storage')->nullable();
            $table->string('port')->nullable();     
            $table->string('price')->nullable();    
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
        Schema::dropIfExists('virtual_machienes');
    }
}
