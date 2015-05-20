<?php

class Usuarios {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('usuarios', function($table){

			$table->increments('id');
			$table->string('username', 60);
			$table->string('password', 100);
			$table->timestamps();

		});

		DB::table('usuarios')->insert(
	        array(
	            'username' => 'admin',
	            'password' => Hash::make('adminradical')
	        )
	    );

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('usuarios');

	}

}