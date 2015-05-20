<?php 
class Estadistica_Controller extends Base_Controller
{

	public $restful = true;

	//en el constructor hacemos uso del filtro before auth, que lo que hace es
	//comprobar si el usuario que intenta acceder ha iniciado sesión, si no es 
	//así lo redirige al login
	public function __construct()
	{

		parent::__construct();		
		//protegemos la entrada si no existe la sesión
		$this->filter('before', 'auth');

	}

	//cargamos la vista home/index.blade.php
	public function get_index()
	{

		return View::make('estadistica.index')->with('title','Estadisticas Inteligencia');

	}

	/*
	//con este sencillo metódo cerramos la sesión del usuario
	public function get_logout()
	{

		Auth::logout();
		return Redirect::to('login')->with('mensaje','¡Has cerrado sesión correctamente!.');

	}
	*/

}
/*
*application/controllers/estadistica.php
*/