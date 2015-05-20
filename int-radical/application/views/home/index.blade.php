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


@section('contenido_home')

	<div class="col-lg-12">
		<!--con Auth::user() podemos acceder a los campos del usuario en la tabla usuarios-->
		Bienvenido {{ Auth::user()->username }}.


		</div>
	    <!-- /.col-lg-12 -->
	</div>
	</div>

{{ HTML::script('css/bower_components/jquery/dist/jquery.min.js') }}
{{ HTML::script('css/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
{{ HTML::script('css/bower_components/metisMenu/dist/metisMenu.min.js') }}
{{ HTML::script('css/bower_components/metisMenu/dist/metisMenu.min.js') }}
{{ HTML::script('css/bower_components/raphael/raphael-min.js') }}
{{ HTML::script('css/bower_components/morrisjs/morris.min.js') }}
{{ HTML::script('js/morris-data.js') }}
{{ HTML::script('js/sb-admin-2.js') }}
 
@endsection
	
