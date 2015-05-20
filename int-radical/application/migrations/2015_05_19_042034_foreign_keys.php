<?php

//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Database\Eloquent\Model;

class Foreign_Keys { //extends Migration {

	public function up()
	{
		Schema::table('cotizaciones', function($table) {
			$table->foreign('id_cotizador')->references('id')->on('cotizador')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('cotizaciones', function($table) {
			$table->foreign('id_tipo_cotizacion')->references('id')->on('tipo_cotizacion')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('cotizaciones', function($table) {
			$table->foreign('id_etapa')->references('id')->on('etapa')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('cotizaciones', function($table) {
			$table->foreign('id_tipologia')->references('id')->on('tipologia')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('cotizaciones', function($table) {
			$table->dropForeign('cotizaciones_id_cotizador_foreign');
		});
		Schema::table('cotizaciones', function($table) {
			$table->dropForeign('cotizaciones_id_tipo_cotizacion_foreign');
		});
		Schema::table('cotizaciones', function($table) {
			$table->dropForeign('cotizaciones_id_etapa_foreign');
		});
		Schema::table('cotizaciones', function($table) {
			$table->dropForeign('cotizaciones_id_tipologia_foreign');
		});
	}
}