@layout('layout')

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{ HTML::link('home', 'Radical Admin', array('class' => 'navbar-brand')) }} 
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-form navbar-right" >
                <div class="form-group">
                    <div class="input-group">
                        {{ HTML::link('home/logout', 'Cerrar Sesión', array('class' => 'btn btn-primary btn-block')) }}
                    </div>      
                </div>
            </div>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{ URL::to('home'); }}"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('cotizacion'); }}"><i class="fa fa-upload fa-fw"></i> Ingresar Bases de Datos</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('estadistica'); }}"><i class="fa fa-gear fa-fw"></i> Estadisticas</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Inteligencia - Radical</h3>
                

@section('titulo')

	Inteligencia - Radical

@endsection


@section('contenido_estadistica')

    <div class="col-lg-12">
        <?php
            // Si tipologia, no se inserta, sino si lo hace
            $cot_array = DB::query('SHOW FULL PROCESSLIST '); 
            if($cot_array != null){
                foreach ($cot_array as $user4) {
                    //echo $user4->info."<br />";
                }

                if(count($cot_array) != 1){
                    ?>
                    <div class="text-center alert alert-success" role="alert" id="flash_notice_ok">
                        <p id="text_ok">
                            <?php 
                                if(count($cot_array)-1 == 1)
                                    echo "Una tarea procesando en este momento, espere porfavor para tener estadisticas finales..."; 
                                else
                                    echo (count($cot_array)-1)." tareas procesando en este momento, espere porfavor para tener estadisticas finales..."; 
                            ?>
                        </p>
                    </div>
                    <?php
                }
            }
        ?>
        <h5>Estadisticas Portal Inmobiliario</h5>

        <div class="text-center alert alert-info" role="alert">
            <?php
                $cot_total = DB::query('select COUNT(id_tipo_cotizacion) AS cont from cotizaciones'); 
                $total = $cot_total[0]->cont;

                $cot_comp = DB::query('select COUNT(id_tipo_cotizacion) AS cont from cotizaciones WHERE id_tipo_cotizacion=4'); 
                $comp = $cot_comp[0]->cont;
                if($comp == 0)
                    $comp = "Sin";

                // Diferencia Dias
                $cot_1 = DB::query('SELECT DISTINCT id_cotizador, fecha FROM cotizaciones WHERE id_tipo_cotizacion=4'); 
                $cont = 0;
                $sum = 0;
                
                if($cot_1 != null){
                    foreach ($cot_1 as $user1) {
                        $cot_1_1 = DB::query('SELECT id, fecha, id_tipo_cotizacion as cont FROM cotizaciones WHERE `id_cotizador` = '.$user1->id_cotizador.' ORDER BY id_tipo_cotizacion ASC'); 
                        
                        $now = strtotime($user1->fecha);
                        $your_date = strtotime($cot_1_1[0]->fecha);
                        $datediff = $now - $your_date;
                        //echo floor($datediff/(60*60*24));

                        $sum += floor($datediff/(60*60*24));
                        $cont++;
                    }
                }    
            ?>
            
            <p>
                <b><?php echo round($sum/$cont); ?></b> días promedio desde punto de contacto a compra
            </p>
            
            <p>
                <b><?php echo $total; ?></b> cotizaciones totales
            </p>

            <p>
                <b><?php echo $comp; ?></b> compradores finales
            </p>
        </div>
    </div>

	<div class="col-lg-4">
        <div id="tipo_cot_chart1" style="height: 200px;"></div>
        <p class="text-center">Graf 1: PORTAL + WEB + SDV = COMPRA</p>
	</div>

    <div class="col-lg-4">
        <div id="tipo_cot_chart2" style="height: 200px;"></div>
        <p class="text-center">Graf 2: WEB + SDV = COMPRA</p>
    </div>

    <div class="col-lg-4">
        <div id="tipo_cot_chart3" style="height: 200px;"></div>
        <p class="text-center">Graf 3: OTRO MEDIO + SDV + COMPRA</p>
    </div>

    <div class="col-lg-4">
        <div id="tipo_cot_chart4" style="height: 200px;"></div>
        <p class="text-center">Graf 4: PORTAL + WEB + SDV</p>
    </div>

    <div class="col-lg-4">
        <div id="tipo_cot_chart5" style="height: 200px;"></div>
        <p class="text-center">Graf 5: WEB + SDV</p>
    </div>

    <div class="col-lg-4">
        <div id="tipo_cot_chart6" style="height: 200px;"></div>
        <p class="text-center">Graf 6: OTRO MEDIO + SDV</p>
    </div>
	    
	</div>
</div>

@endsection
	
