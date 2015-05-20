<?php

class Tipologia {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */

	public function up()
	{
		Schema::create('tipologias', function($table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('nombre');
		});

		DB::table('tipologias')->insert(
	        array(
	            'nombre' => 'Tipologia test1'
	        )
	    );
	}

	public function down()
	{
		Schema::drop('tipologia');
	}
}