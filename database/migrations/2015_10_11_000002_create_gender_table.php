<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGenderTable extends Migration {

	public function up()
	{
		Schema::create('genders', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('gender');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('gender');
	}
}