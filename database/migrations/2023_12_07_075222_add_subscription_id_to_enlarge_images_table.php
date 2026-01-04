<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionIdToEnlargeImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enlarge_images', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id')->nullable()->after('user_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enlarge_images', function (Blueprint $table) {
            $table->dropColumn('subscription_id');
        });
    }
}
