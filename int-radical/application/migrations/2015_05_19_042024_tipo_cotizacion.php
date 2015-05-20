<?php

class Tipo_Cotizacion {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */	

	public function up()
	{
		Schema::create('tipo_cotizaciones', function($table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('nombre');
		});

		DB::table('tipo_cotizaciones')->insert(
	        array(
	            'nombre' => 'Tipo Cotizacion test1'
	        )
	    );
	}

	public function down()
	{
		Schema::drop('tipo_cotizacion');
	}
}