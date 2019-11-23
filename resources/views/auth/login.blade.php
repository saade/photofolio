<!DOCTYPE html>
<html>
<head>
	<title>Yahoooo</title>
	<link rel="stylesheet" type="text/css" href="{{ photofolio_asset('css/app.css') }}&version={{ uniqid() }}">
	<style type="text/css">
		html,
		body {
		  height: 100%;
		}

		body {
		  display: -ms-flexbox;
		  display: -webkit-box;
		  display: flex;
		  -ms-flex-align: center;
		  -ms-flex-pack: center;
		  -webkit-box-align: center;
		  align-items: center;
		  -webkit-box-pack: center;
		  justify-content: center;
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #f5f5f5;
		}

		.form-signin {
		  width: 100%;
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		}
		.form-signin .checkbox {
		  font-weight: 400;
		}
		.form-signin .form-control {
		  position: relative;
		  box-sizing: border-box;
		  height: auto;
		  padding: 10px;
		  font-size: 16px;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="email"] {
		  margin-bottom: -1px;
		  border-bottom-right-radius: 0;
		  border-bottom-left-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}
	</style>
</head>
<body class="text-center">
{{-- 	@if(count($errors) > 0)
      <div class="alert alert-danger" role="alert">
		  	<ul class="list-unstyled">
	            @foreach($errors->all() as $err)
	            <li>{{ $err }}</li>
	            @endforeach
	        </ul>
		</div>
      @endif --}}
	<form class="form-signin" action="{{ route('photofolio.login') }}" method="POST">
	  <a class="h1" href="#" style="letter-spacing: 2px">PHOTOFOLIO</a>
	  <hr>
	  <h1 class="h6 mb-3 font-weight-normal">Por favor, faça login</h1>
	  <label for="inputEmail" class="sr-only">Email</label>
	  <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Email" class="form-control" required>
	  <label for="inputPassword" class="sr-only">Senha</label>
	  <input type="password" name="password" placeholder="Senha" class="form-control" required>
	  <div class="checkbox mb-3">
	    <label>
	      <input type="checkbox" value="remember-me"> Lembrar-me
	    </label>
	  </div>{{ @csrf_field() }}
	  <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
	  <p class="mt-5 mb-3 text-muted">© Photofolio 2019</p>
	</form>
</body>
</html>