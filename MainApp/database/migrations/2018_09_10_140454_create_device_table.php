<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('device', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('deviceId', 191)->nullable();
			$table->string('title', 191)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('message_url', 191)->nullable();
			$table->text('content_available', 65535)->nullable();
			$table->integer('priority')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('device');
	}

}
