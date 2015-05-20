<?php

class Cotizador {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */

	public function up()
	{
		Schema::create('cotizadores', function($table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('rut');
			$table->string('dv', 1);
			$table->string('nombre');
			$table->string('apellido');
			$table->string('email');
		});

		DB::table('cotizadores')->insert(
	        array(
	            'rut' => 16846047,
	            'dv' => '3',
	            'nombre' => 'Anibal',
	            'apellido' => 'Bastias Soto',
	            'email' => 'anibal.bastias@gmail.com'
	        )
	    );
	}

	public function down()
	{
		Schema::drop('cotizador');
	}
}