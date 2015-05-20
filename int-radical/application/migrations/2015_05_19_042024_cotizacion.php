<?php

class Cotizacion {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */

	public function up()
	{
		Schema::create('cotizaciones', function($table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('id_cotizador')->unsigned();
			$table->integer('id_tipo_cotizacion')->unsigned();
			$table->integer('id_etapa')->unsigned();
			$table->integer('id_tipologia')->unsigned();
			$table->integer('cant_dormitorios');
		});

		DB::table('cotizaciones')->insert(
	        array(
	            'id_cotizador' => 1,
	            'id_tipo_cotizacion' => 1,
	            'id_etapa' => 1,
	            'id_tipologia' => 1,
	            'cant_dormitorios' => 10
	        )
	    );
	}

	public function down()
	{
		Schema::drop('cotizacion');
	}
}