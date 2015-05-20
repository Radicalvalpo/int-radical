<!DOCTYPE HTML>
<html lang="es-ES">
    <head>
        <meta charset="UTF-8">
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

        {{ HTML::script('css/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
        {{ HTML::script('css/bower_components/raphael/raphael-min.js') }}
        {{ HTML::script('css/bower_components/jquery/dist/jquery.min.js') }}
        {{ HTML::script('css/bower_components/morrisjs/morris.min.js') }}
        {{ HTML::script('css/bower_components/metisMenu/dist/metisMenu.min.js') }}
        {{ HTML::script('js/sb-admin-2.js') }}
        
        <script type="text/javascript">
        $(function() {
            // Chart 1
            Morris.Donut({
              element: 'tipo_cot_chart1',
              data: [
                <?php
                    // Si tipologia, no se inserta, sino si lo hace
                    $cot_array = DB::query('select tipo_cotizaciones.nombre, COUNT(cotizaciones.id_tipo_cotizacion) AS cont from cotizaciones, tipo_cotizaciones WHERE tipo_cotizaciones.id=cotizaciones.id_tipo_cotizacion'); 
                    if($cot_array != null){
                        foreach ($cot_array as $user4) {
                            ?>
                            {label: <?php echo '"'.$user4->nombre.'"'; ?> , value: <?php echo $user4->cont; ?>},
                            <?php
                        }
                    }
                ?>
              ]
            });

            // Chart 2
        });
        </script>
        
        
    </body>
</html>