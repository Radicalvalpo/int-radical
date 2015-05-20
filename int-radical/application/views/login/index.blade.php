@layout('layout')

@section('titulo')

	Inteligencia Radical	

@endsection

@section('mensaje')

	Inteligencia - Radical

@endsection


@section('contenido')
 
 	<div class="form login-form">

		{{ Form::open('login') }}

			<!-- Revisemos si tenemos errores de login -->
	        <div class="form-group">
              <input type="text" name="username" class="form-control login-field" value="" placeholder="Usuario" id="login-name" />
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="form-group">
              <input type="password" name="password" class="form-control login-field" value="" placeholder="Contraseña" id="login-pass" />
              <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>
	 
			@if (Session::has('error_login'))
				<span class="error text-center">Usuario o contraseña incorrectos.</span>
			@endif
			
	    	@if(Session::has('mensaje'))
            	<div class="text-center" id="flash_notice">{{ Session::get('mensaje') }}</div>
         	@endif

	        <input value="Iniciar sesión" class="btn btn-primary btn-lg btn-block" type="submit">
 
	    {{ Form::close() }}

	    <!--si intentan ir a la home sin inciar sesión o han cerrado sesión mostramos un mensaje-->


	</div>

@endsection
	
