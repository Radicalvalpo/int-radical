<?php

class Etapa {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */

	public function up()
	{
		Schema::create('etapas', function($table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('nombre');
		});

		DB::table('etapas')->insert(
	        array(
	            'nombre' => 'Etapa test1'
	        )
	    );
	}

	public function down()
	{
		Schema::drop('etapa');
	}
}