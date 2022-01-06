<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrModifyingPusherTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pusher', function (Blueprint $table) {

            $table->dropColumn('deviceId');
            $table->dropColumn('token');

            $table->string('device_id', 355)->nullable();
            $table->string('registration_id', 355)->nullable();
            $table->string('push_enable', 20)->nullable();
            $table->string('platform', 50)->nullable();
            $table->string('user_email', 335)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pusher', function (Blueprint $table) {
            $table->dropColumn('push_enable');
            $table->dropColumn('platform');
            $table->dropColumn('user_email');
        });
    }
}
