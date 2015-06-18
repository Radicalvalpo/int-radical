<?php 


class Cotizacion_Controller extends Base_Controller
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

		return View::make('cotizacion.index')->with('title','Cotizaciones Inteligencia');

	}

	public function post_index()	
	{
		$date = new \DateTime;
		//recogemos los campos del formulario y los guardamos en un array
		//para pasarselo al método Auth::attempt
		$data = array(
			'file' => Input::file('file'),
			'tipo_cotizacion'=> Input::get('tipo_cotizacion')
		); 

		// setting up rules
		$rules = array('file' => 'required', 
					   'tipo_cotizacion' => 'required');

		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			// send back to the page with the input data and errors
			return Redirect::to('cotizacion')->with('mensaje_error','Debe adjuntar archivo y seleccionar tipo de entrada');
		}
		else {
			$tipo_cot1 = Input::get('tipo_cotizacion');
      		$destinationPath = path('public').'excel/uploads/';
		    $fileName = $tipo_cot1.'_'.$date->format('Y-m-d H:i:s').'.xlsx'; // renameing image
		    
		    Input::upload('file', $destinationPath, $fileName);

	      	// PHP Excel
	      	$objPHPExcel = new PHPExcel();
	      	$objPHPExcel = PHPExcel_IOFactory::load($destinationPath.$fileName);

			$objWorksheet = $objPHPExcel->getActiveSheet();

			$maxCell = $objWorksheet->getHighestRowAndColumn();
			$data = $objWorksheet->rangeToArray('A8:' . $maxCell['column'] . $maxCell['row']);

			/////////////////////////////////////////////////////////////////////////////////
			$date1 = $date->format('Y-m-d H:i:s');
			
			$cotizadores_array = DB::query('select id,rut from cotizadores');
			//$tipo_cotizacion_array = DB::query('select id,nombre from tipo_cotizaciones'); 
			//$etapas_array = DB::query('select id,nombre from etapas'); 
			//$tipologia_array = DB::query('select id,nombre from tipologias'); 
			
			foreach ($data as $col) {
			    $cellA = $col[0];
			    $cellB = $col[1];
			    $cellC = $col[2];
			    $cellD = $col[3];
			    $cellE = $col[4];
			    $cellF = $col[5];
			    $cellG = $col[6];
			    $cellH = $col[7];
			    $cellI = $col[8];

			    // Validacion null
			    if ($cellA == NULL || $cellA == '')
			    	$cellA = "OTRO";
			    if ($cellB == NULL || $cellB == '')
			    	$cellB = $date1;
			    if ($cellC == NULL || $cellC == '')
			    	$cellC = "0-0";
			    if ($cellD == NULL || $cellD == '')
			    	$cellD = "";
			    if ($cellE == NULL || $cellE == '')
			    	$cellE = "";
			    if ($cellF == NULL || $cellF == '')
			    	$cellF = "";
			    if ($cellG == NULL || $cellG == '')
			    	$cellG = "";
			    if ($cellH == NULL || $cellH == '')
			    	$cellH = 5;
			    if ($cellI == NULL || $cellI == '')
			    	$cellI = 0;

			    // Asignacion Variables
				$tipo_cot = $cellA;
				$fecha_cot = $cellB;

				// Convertir fechas correctamente
				

				$rut_completo = str_replace('.', '', str_replace('-', '', $cellC));
				$rut = substr($rut_completo, 0, -1);
				$dv = substr($rut_completo, -1);

				$nombre = $cellD;
				$apellido = $cellE;
				$email = $cellF;
				$etapa = $cellG;
				$tipologia = $cellH;
				$dormitorios = $cellI;

				// Regla de Negocios
				$id_cotizador = 0;
				$id_cotizacion = 0;
				$id_tipo_cotizacion = 0;
				$id_etapa = 0;
				$id_tipologia = 0;

				/* Si existe rut de cotizador, no se inserta, sino inserta.				
				 *
				 */
				if($cotizadores_array != null){
					foreach ($cotizadores_array as $user1) {
		            	if(strcmp($user1->rut, $rut) != 0){
		            		try {
		            			$success1 = DB::query('insert ignore into cotizadores '.
		            				'(rut, dv, nombre, apellido, email, created_at, updated_at) '.
		            				'values '.
		            				'("'.$rut.'", "'.$dv.'", "'.$nombre.'", "'.$apellido.'", "'.$email.'", "'.$date1.'", "'.$date1.'")');

		            			if($success1){
		            				$id_cotizador_array = DB::query('select id from cotizadores where rut="'.$rut.'"');
		            				$id_cotizador = $id_cotizador_array[0]->id;
		            			}
							} catch (Exception $e) {
							    //var_dump($e->errorInfo );
							    $id_cotizador = $user1->id;
							}
		            	}
		            	else{
            				$id_cotizador = $user1->id;
		            	}
		            }	
				}
				else{
					$success1 = DB::query('insert ignore into cotizadores '.
        				'(rut, dv, nombre, apellido, email, created_at, updated_at) '.
        				'values '.
        				'("'.$rut.'", "'.$dv.'", "'.$nombre.'", "'.$apellido.'", "'.$email.'", "'.$date1.'", "'.$date1.'")');

        			if($success1){
        				$id_cotizador_array = DB::query('select id from cotizadores where rut="'.$rut.'"');
        				$id_cotizador = $id_cotizador_array[0]->id;
        			}
				}
	            
				/** Si existe tipo de cotizacion, no se inserta, sino si lo hace
				 *
				 */
				if($tipo_cot == "WEB")
					$id_tipo_cotizacion = 1;
				if($tipo_cot == "SDV")
					$id_tipo_cotizacion = 2;
				if($tipo_cot == "PI")
					$id_tipo_cotizacion = 3;
				if($tipo_cot == "COMPRADOR")
					$id_tipo_cotizacion = 4;
				if($tipo_cot == "OTRO")
					$id_tipo_cotizacion = 5;
				/*
				if($tipo_cotizacion_array != null){
		            foreach ($tipo_cotizacion_array as $user2) {
		            	if(strcmp($user2->nombre, $tipo_cot) != 0){
	            			try {
				    			$success2 = DB::query('insert ignore into tipo_cotizaciones '.
				    				'(nombre, created_at, updated_at) '.
				    				'values '.
				    				'("'.$tipo_cot.'", "'.$date1.'", "'.$date1.'")');

				    			if($success2){
				    				$id_tipo_cotizacion_array = DB::query('select * from tipo_cotizaciones where nombre="'.$tipo_cot.'"');
				    				$id_tipo_cotizacion = $tipo_cotizacion_array[0]->id;
				    			}
							} catch (Exception $e) {
							    //var_dump($e->errorInfo );
							    $id_tipo_cotizacion = $user2->id;
							}
		            	}
		            	else{
            				$id_tipo_cotizacion = $user2->id;
		            	}
		            }
		        }
		        else{
		        	$success2 = DB::query('insert ignore into tipo_cotizaciones '.
	    				'(nombre, created_at, updated_at) '.
	    				'values '.
	    				'("'.$tipo_cot.'", "'.$date1.'", "'.$date1.'")');

	    			if($success2){
	    				$id_tipo_cotizacion_array = DB::query('select * from tipo_cotizaciones where nombre="'.$tipo_cot.'"');
	    				$id_tipo_cotizacion = $id_tipo_cotizacion_array[0]->id;
	    			}
		        }
		        */

				/* Si existe etapa, no se inserta, sino si lo hace
				 *
				 */
				/*
				if($etapas_array != null){
		            foreach ($etapas_array as $user3) {
		            	if(strcmp($user3->nombre, $etapa) != 0){
	            			try {
				    			$success3 = DB::query('insert ignore into etapas '.
				    				'(nombre, created_at, updated_at) '.
				    				'values '.
				    				'("'.$etapa.'", "'.$date1.'", "'.$date1.'")');

				    			if($success3){
				    				$id_etapa_array = DB::query('select * from etapas where nombre="'.$etapa.'"');
				    				$id_etapa = $id_etapa_array[0]->id;
				    			}
							} catch (Exception $e) {
							    //var_dump($e->errorInfo );
							    $id_etapa = $user3->id;
							}
		            	}
		            	else{
            				$id_etapa = $user3->id;
		            	}
		            }
		        }
		        else{
		        	$success3 = DB::query('insert ignore into etapas '.
	    				'(nombre, created_at, updated_at) '.
	    				'values '.
	    				'("'.$etapa.'", "'.$date1.'", "'.$date1.'")');

	    			if($success3){
	    				$id_etapa_array = DB::query('select * from etapas where nombre="'.$etapa.'"');
	    				$id_etapa = $id_etapa_array[0]->id;
	    			}
		        }
		        */

				/* Si tipologia, no se inserta, sino si lo hace
				 *
				 */
				/*
				if($tipologia_array != null){
		            foreach ($tipologia_array as $user4) {
		            	if(strcmp($user4->nombre, $tipologia) != 0){
	            			try {
				    			$success4 = DB::query('insert ignore into tipologias '.
				    				'(nombre, created_at, updated_at) '.
				    				'values '.
				    				'("'.$tipologia.'", "'.$date1.'", "'.$date1.'")');

				    			if($success4){
				    				$id_tipologia_array = DB::query('select * from tipologias where nombre="'.$tipologia.'"');
				    				$id_tipologia = $id_tipologia_array[0]->id;
				    			}
							} catch (Exception $e) {
							    //var_dump($e->errorInfo );
							    $id_etapa = $user4->id;
							}
		            	}
		            	else{
            				$id_tipologia = $user4->id;
		            	}
		            }
		        }
		        else{
		        	$success4 = DB::query('insert ignore into tipologias '.
	    				'(nombre, created_at, updated_at) '.
	    				'values '.
	    				'("'.$tipologia.'", "'.$date1.'", "'.$date1.'")');

	    			if($success4){
	    				$id_tipologia_array = DB::query('select * from tipologias where nombre="'.$tipologia.'"');
	    				$id_tipologia = $id_tipologia_array[0]->id;
	    			}
		        }
		        */

				/* Se inserta registro de cotizacion
				 *
				 */
				DB::table('cotizaciones')->insert(array(
					'id_cotizador' => $id_cotizador,
					'id_tipo_cotizacion' => $id_tipo_cotizacion,
					//'id_etapa' => $id_etapa,
					//'id_tipologia' => $id_tipologia,
					'etapa' => $etapa,
					'tipologia' => $tipologia,
					'fecha' => $fecha_cot,
					'cant_dormitorios' => $dormitorios,
					'created_at' => $date,
					'updated_at' => $date));			
		    }
		    return Redirect::to('cotizacion')->with('mensaje_ok','Archivo procesado correctamente.');
		}
	}
}
/*
*application/controllers/cotizacion.php
*/