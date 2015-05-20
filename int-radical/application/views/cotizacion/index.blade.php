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


@section('contenido_cotizacion')

	<div class="col-lg-12">
		<!--con Auth::user() podemos acceder a los campos del usuario en la tabla usuarios-->
        @if(Session::has('mensaje_error'))
                <div class="text-center" id="flash_notice"><p class="bg-danger">{{ Session::get('mensaje_error') }}</p></div>
        @endif

        @if(Session::has('mensaje_ok'))
                <div class="text-center" id="flash_notice"><p class="bg-success">{{ Session::get('mensaje_ok') }}</p></div>
        @endif

		<p><strong>Ingresar Cotizacion</strong></p>

        {{ Form::open_for_files('cotizacion') }}
           <div class="form-group">
              <label for="name">Ingrese archivo en formato .xls o .xls (Microsoft Excel) a adjuntar</label>
              <br />

              {{ HTML::image('img/excel_logo.png','Ejemplo Excel', array( 'width' => 30, 'height' => 30 )) }} 
              {{ HTML::link('excel/ejemplo_inteligencia.xlsx', 'Formato ejemplo Excel') }}

              <br /><br />
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-file">
                            Adjuntar&hellip; <input name="file" accept=".xls, .xlsx" type="file" multiple>
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
                <span class="help-block">
                    Seleccione un archivo excel correspondiente al formato de ejemplo
                </span>

              <br />

              <label for="name">Seleccione tipo de entrada de Base de Datos</label>
              <select name="tipo_cotizacion" size=5  multiple class="form-control">
                 <option value="SDV">SDV</option>
                 <option value="Web">Web</option>
                 <option value="Portal Inmobilario">Portal Inmobiliario</option>
                 <option value="Comprador">Comprador</option>
                 <option value="Otro">Otro</option>
              </select>

              <br />

              <input value="Ingresar Registro" class="btn btn-primary btn-lg btn-block" type="submit">
           </div>
        {{ Form::close() }}

		</div>
	    <!-- /.col-lg-12 -->
	</div>
	</div>

 
@endsection
	
