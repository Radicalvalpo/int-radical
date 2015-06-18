<!DOCTYPE HTML>
<html lang="es-ES">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Radical">
        <meta name="viewport" content="width=device-width">

        <!--nuestro título podrá ser modificado-->
        <title>@yield('titulo')</title>
        {{ HTML::style('css/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
        {{ HTML::style('css/flat-ui.css') }}
        {{ HTML::style('css/file.css') }}
        {{ HTML::style('css/bower_components/metisMenu/dist/metisMenu.min.css') }}
        {{ HTML::style('css/timeline.css') }}
        {{ HTML::style('css/sb-admin-2.css') }}
        {{ HTML::style('css/bower_components/morrisjs/morris.css') }}
        {{ HTML::style('css/bower_components/font-awesome/css/font-awesome.min.css') }}
        {{ HTML::style('css/jquery.progresstimer.min.css') }}   

    </head>
    <body>
        <div class="container">
                <h3 class="text-center">@yield('mensaje')</h1>
          
                <div>
                    <!--nuestro contenido es igual que el sidebar, no tiene ningún contenido 
                    por defecto, pero se lo podemos añadir y llamarlo con @parent-->
                    <div class="content">
                        <div class="col-xs-4"> </div>
                        <div class="col-xs-4">
                                @yield('contenido')
                        </div>
                        <div class="col-xs-4"> </div>           
                    </div>
                    <!--fin de nuestro sidebar-->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">@yield('contenido_home')</div>
            <div class="col-xs-12">@yield('contenido_cotizacion')</div>
            <div class="col-xs-12">@yield('contenido_estadistica')</div>
        </div>

        {{ HTML::script('css/bower_components/raphael/raphael-min.js') }}
        {{ HTML::script('css/bower_components/jquery/dist/jquery.min.js') }}
        {{ HTML::script('css/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
        {{ HTML::script('css/bower_components/morrisjs/morris.min.js') }}
        {{ HTML::script('css/bower_components/metisMenu/dist/metisMenu.min.js') }}
        {{ HTML::script('js/sb-admin-2.js') }}
        {{ HTML::script('js/jquery.progressTimer.js') }}
        {{ HTML::script('js/jquery.ajax-progress.js') }}
        
        <script type="text/javascript">
        
        $(function() {
            
            <?php
            $cot_total = DB::query('select COUNT(id_tipo_cotizacion) AS cont from cotizaciones'); 
            $total = $cot_total[0]->cont;
            ?>
            var total = <?php echo $total; ?>;

            // Grafico 1: PORTAL + WEB + SDV = COMPRA
            Morris.Donut({
              element: 'tipo_cot_chart1',
              formatter: function (value, data) { return Math.round(value/total *100) + '%'; },
              data: [
                <?php
                    $cot_1 = DB::query('SELECT DISTINCT id_cotizador FROM cotizaciones WHERE id_tipo_cotizacion=4'); 
                    if($cot_1 != null){
                        $cont = 0;
                        foreach ($cot_1 as $user1) {
                            $cot_1_1 = DB::query('SELECT COUNT(id)-1 as cont FROM cotizaciones WHERE id_tipo_cotizacion!=5 AND `id_cotizador` = '.$user1->id_cotizador.' ORDER BY id_tipo_cotizacion ASC '); 
                            $cont++;
                        }
                        ?>
                        {label: <?php echo '"SI"'; ?> , value: <?php echo $cont; ?>},
                        <?php
                        
                    }    
                ?>
              ]
            });

            // Grafico 2: WEB + SDV = COMPRA
            Morris.Donut({
              element: 'tipo_cot_chart2',
              formatter: function (value, data) { return Math.round(value/total *100) + '%'; },
              data: [
                <?php
                    $cot_2 = DB::query('SELECT DISTINCT id_cotizador FROM cotizaciones WHERE id_tipo_cotizacion=4'); 
                    if($cot_2 != null){
                        $cont = 0;
                        foreach ($cot_2 as $user2) {
                            $cot_2_1 = DB::query('SELECT COUNT(id)-1 as cont FROM cotizaciones WHERE id_tipo_cotizacion!=5 AND id_tipo_cotizacion!=3 AND `id_cotizador` = '.$user2->id_cotizador.' ORDER BY id_tipo_cotizacion ASC '); 
                            $cont++;
                        }
                        ?>
                        {label: <?php echo '"SI"'; ?> , value: <?php echo $cont; ?>},
                        <?php
                        
                    }    
                ?>
              ]
            });

            // Grafico 3: OTRO MEDIO + SDV + COMPRA
            Morris.Donut({
              element: 'tipo_cot_chart3',
              formatter: function (value, data) { return Math.round(value/total *100) + '%'; },
              data: [
                <?php
                    $cot_3 = DB::query('select COUNT(id) AS cont from cotizaciones WHERE id_tipo_cotizacion=5 OR id_tipo_cotizacion=2 OR id_tipo_cotizacion=4'); 
                    if($cot_3 != null){
                        ?>
                        {label: <?php echo '"SI"'; ?> , value: <?php echo $cot_3[0]->cont; ?>},

                        <?php
                    }    
                    
                ?>
              ]
            });

            // Grafico 4: PORTAL + WEB + SDV
            Morris.Donut({
              element: 'tipo_cot_chart4',
              formatter: function (value, data) { return Math.round(value/total *100) + '%'; },
              data: [
                <?php
                    $cot_4 = DB::query('select COUNT(id) AS cont from cotizaciones WHERE id_tipo_cotizacion=1 OR id_tipo_cotizacion=2 OR id_tipo_cotizacion=3'); 
                    if($cot_4 != null){
                        ?>
                        {label: <?php echo '"SI"'; ?> , value: <?php echo $cot_4[0]->cont; ?>},

                        <?php
                    }    
                    
                ?>
              ]
            });

            // Grafico 5: WEB + SDV
            Morris.Donut({
              element: 'tipo_cot_chart5',
              formatter: function (value, data) { return Math.round(value/total *100) + '%'; },
              data: [
                <?php
                    $cot_5 = DB::query('select COUNT(id) AS cont from cotizaciones WHERE id_tipo_cotizacion=1 OR id_tipo_cotizacion=2'); 
                    if($cot_5 != null){
                        ?>
                        {label: <?php echo '"SI"'; ?> , value: <?php echo $cot_5[0]->cont; ?>},

                        <?php
                    }    
                    
                ?>
              ]
            });

            // Grafico 6: OTRO MEDIO + SDV
            Morris.Donut({
              element: 'tipo_cot_chart6',
              formatter: function (value, data) { return Math.round(value/total *100) + '%'; },
              data: [
                <?php
                    $cot_6 = DB::query('select COUNT(id) AS cont from cotizaciones WHERE id_tipo_cotizacion=2 OR id_tipo_cotizacion=5'); 
                    if($cot_6 != null){
                        ?>
                        {label: <?php echo '"SI"'; ?> , value: <?php echo $cot_6[0]->cont; ?>},

                        <?php
                    }    
                    
                ?>
              ]
            });


        });
        </script>

        <script type="text/javascript">

            $("form#data").submit(function(){

                var formData = new FormData($(this)[0]);
                
                var progress = $(".loading-progress").progressTimer({
                  timeLimit: 10,
                  onFinish: function () {
                    $("#flash_notice_loading").css('display', 'none');
                    $("#text_loading").empty();

                    $("#flash_notice_ok").css('display', 'block');
                    $("#text_ok").text("Archivo procesado correctamente");
                }
                });

                $.ajax({
                   url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        // setting a timeout
                        $("#flash_notice_ok").css('display', 'none');
                        $("#text_ok").empty();

                        $("#flash_notice_error").css('display', 'none');
                        $("#text_error").empty();

                        $("#flash_notice_loading").css('display', 'block');
                        $("#text_loading").text("Cargando ...");
                    }
                  }).error(function(){
                  progress.progressTimer('error', {
                  errorText:'Error',
                  onFinish:function(){
                    $("#flash_notice_loading").css('display', 'none');
                    $("#text_loading").empty();

                    $("#flash_notice_error").css('display', 'block');
                    $("#text_error").text("Error, no se pudo cargar correctamente");
                  }
                });
                }).done(function(){
                  progress.progressTimer('complete');
                });
                
                return false;
            });
        </script>
        
        
    </body>
</html>