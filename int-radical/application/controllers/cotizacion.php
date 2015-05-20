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
			//try
			//{
			$tipo_cot1 = Input::get('tipo_cotizacion');
      		$destinationPath = path('public').'excel/uploads/';
		    $fileName = $tipo_cot1.'_'.$date->format('Y-m-d H:i:s').'.xlsx'; // renameing image
		    
		    Input::upload('file', $destinationPath, $fileName);

	      	// PHP Excel
	      	$objPHPExcel = new PHPExcel();
	      	$objPHPExcel = PHPExcel_IOFactory::load($destinationPath.$fileName);

			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow();

			$rows = 0;
			$rowIndex = 8;

			foreach ($objWorksheet->getRowIterator() as $row) {
				$cellIterator = $row->getCellIterator();
			    $cellIterator->setIterateOnlyExistingCells(true); // Loop all cells, even if empty

			    //$rowIndex = $row->getRowIndex();
			    $cellA = $objWorksheet->getCell('A' . $rowIndex);
			    $cellB = $objWorksheet->getCell('B' . $rowIndex);
			    $cellC = $objWorksheet->getCell('C' . $rowIndex);
			    $cellD = $objWorksheet->getCell('D' . $rowIndex);
			    $cellE = $objWorksheet->getCell('E' . $rowIndex);
			    $cellF = $objWorksheet->getCell('F' . $rowIndex);
			    $cellG = $objWorksheet->getCell('G' . $rowIndex);
			    $cellH = $objWorksheet->getCell('H' . $rowIndex);
			    $cellI = $objWorksheet->getCell('I' . $rowIndex);
			    
				if (!is_null($cellA) && !is_null($cellB) && !is_null($cellC) && !is_null($cellD) && 
					!is_null($cellE) && !is_null($cellF) && !is_null($cellG) && !is_null($cellH) && 
					!is_null($cellI)) {
					$tipo_cot = $objWorksheet->getCell('A'.$rowIndex)->getCalculatedValue();
					$fecha_cot = $objWorksheet->getCell('B'.$rowIndex)->getCalculatedValue();

					$rut_completo = str_replace('.', '', str_replace('-', '', $objWorksheet->getCell('C'.$rowIndex)->getCalculatedValue()));
					$rut = substr($rut_completo, 0, -1);
					$dv = substr($rut_completo, -1);

					$nombre = $objWorksheet->getCell('D'.$rowIndex)->getCalculatedValue();
					$apellido = $objWorksheet->getCell('E'.$rowIndex)->getCalculatedValue();
					$email = $objWorksheet->getCell('F'.$rowIndex)->getCalculatedValue();
					$etapa = $objWorksheet->getCell('G'.$rowIndex)->getCalculatedValue();
					$tipologia = $objWorksheet->getCell('H'.$rowIndex)->getCalculatedValue();
					$dormitorios = $objWorksheet->getCell('I'.$rowIndex)->getCalculatedValue();

					// Insert at Usuario
					if(!is_null($nombre)){

						// Regla de Negocios
						$id_cotizador = 0;
						$id_cotizacion = 0;
						$id_tipo_cotizacion = 0;
						$id_etapa = 0;
						$id_tipologia = 0;

						// Si existe rut de cotizador, no se inserta, sino si lo hace
						$cotizadores_array = DB::query('select * from cotizadores');
						if($cotizadores_array != null){
							foreach ($cotizadores_array as $user1) {
				            	if(strcmp($user1->rut, $rut) != 0){
			            			$id_cotizador = DB::table('cotizadores')->insert_get_id(array(
										'rut' => $rut,
										'dv' => $dv,
										'nombre' => $nombre,
										'apellido' => $apellido,
										'email' => $email,
										'created_at' => $date,
										'updated_at' => $date));
				            	}
				            	else{
		            				$id_cotizador = $user1->id;
				            	}
				            }	
						}
						else{
							$id_cotizador = DB::table('cotizadores')->insert_get_id(array(
								'rut' => $rut,
								'dv' => $dv,
								'nombre' => $nombre,
								'apellido' => $apellido,
								'email' => $email,
								'created_at' => $date,
								'updated_at' => $date));
						}
			            

						// Si existe tipo de cotizacion, no se inserta, sino si lo hace
						$tipo_cotizacion_array = DB::query('select * from tipo_cotizaciones'); 
						if($tipo_cotizacion_array != null){
				            foreach ($tipo_cotizacion_array as $user2) {
				            	if(strcmp($user2->nombre, $tipo_cot) != 0){
			            			$id_tipo_cotizacion = DB::table('tipo_cotizaciones')->insert_get_id(array(
										'nombre' => $tipo_cot,
										'created_at' => $date,
										'updated_at' => $date));
				            	}
				            	else{
		            				$id_tipo_cotizacion = $user2->nombre;
				            	}
				            }
				        }
				        else{
				        	$id_tipo_cotizacion = DB::table('tipo_cotizaciones')->insert_get_id(array(
								'nombre' => $tipo_cot,
								'created_at' => $date,
								'updated_at' => $date));
				        }

						// Si existe etapa, no se inserta, sino si lo hace
						$etapas_array = DB::query('select * from etapas'); 
						if($etapas_array != null){
				            foreach ($etapas_array as $user3) {
				            	if(strcmp($user3->nombre, $etapa) != 0){
			            			$id_etapa = DB::table('etapas')->insert_get_id(array(
										'nombre' => $etapa,
										'created_at' => $date,
										'updated_at' => $date));
				            	}
				            	else{
		            				$id_etapa = $user3->nombre;
				            	}
				            }
				        }
				        else{
				        	$id_etapa = DB::table('etapas')->insert_get_id(array(
								'nombre' => $etapa,
								'created_at' => $date,
								'updated_at' => $date));
				        }

						// Si tipologia, no se inserta, sino si lo hace
						$tipologia_array = DB::query('select * from tipologias'); 
						if($tipologia_array != null){
				            foreach ($tipologia_array as $user4) {
				            	if(strcmp($user4->nombre, $tipologia) != 0){
			            			$id_tipologia = DB::table('tipologias')->insert_get_id(array(
										'nombre' => $tipologia,
										'created_at' => $date,
										'updated_at' => $date));
				            	}
				            	else{
		            				$id_tipologia = $user4->nombre;
				            	}
				            }
				        }
				        else{
				        	$id_tipologia = DB::table('tipologias')->insert_get_id(array(
								'nombre' => $tipologia,
								'created_at' => $date,
								'updated_at' => $date));
				        }

						// Se inserta registro de cotizacion
						DB::table('cotizaciones')->insert(array(
							'id_cotizador' => $id_cotizador,
							'id_tipo_cotizacion' => $id_tipo_cotizacion,
							'id_etapa' => $id_etapa,
							'id_tipologia' => $id_tipologia,
							'cant_dormitorios' => $dormitorios,
							'created_at' => $date,
							'updated_at' => $date));		
					}
					else{
						return Redirect::to('cotizacion')->with('mensaje_ok','Archivo procesado correctamente.');
					}
					$rows++;
				}	
				else{
					return Redirect::to('cotizacion')->with('mensaje_ok','Archivo procesado correctamente.');
				}
				$rowIndex++;	
		    }
		    return Redirect::to('cotizacion')->with('mensaje_ok','Archivo procesado correctamente.');
			
		}
	}
}
/*
*application/controllers/cotizacion.php
*/