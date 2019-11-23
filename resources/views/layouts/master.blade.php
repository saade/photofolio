<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.name', 'powered by Photofolio') }} Admin</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{ photofolio_asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ photofolio_asset('css/app.css') }}">
	<script type="text/javascript" src="{{ photofolio_asset('js/app.js') }}" defer></script>
</head>
<body>
	<div id="app">
		<div v-cloak>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			  <div class="container">
			  	<a class="navbar-brand" href="#" style="letter-spacing: 2px;">PHOTOFOLIO</a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>

				  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				    <ul class="navbar-nav ml-auto flex-row">
				      <li class="nav-item mr-3 {{ Route::is('photofolio.dashboard*') ? 'active' : '' }}">
				        <a class="nav-link {{ Route::is('photofolio.dashboard*') ? 'font-weight-bold text-primary' : '' }}" href="{{ route('photofolio.dashboard') }}">Dashboard</a>
				      </li>
				      <li class="nav-item mx-3 {{ Route::is('photofolio.portifolio*') ? 'active' : '' }}">
				        <a class="nav-link {{ Route::is('photofolio.portifolio*') ? 'font-weight-bold text-primary' : '' }}" href="{{ route('photofolio.portifolio.index') }}">Portifólios</a>
				      </li>
				      <li class="nav-item ml-3 {{ Route::is('photofolio.category*') ? 'active' : '' }}">
				        <a class="nav-link {{ Route::is('photofolio.category*') ? 'font-weight-bold text-primary' : '' }}" href="{{ route('photofolio.category.index') }}">Categorias</a>
				      </li>
				    </ul>
				  </div>
				  	<div class="dropdown ml-5">
					  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    {{ \Auth::user()->name }}
					  </button>
					  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
					    <form action="/admin/logout" method="POST">
							{{ @csrf_field() }}
					    	<button type="submit" class="btn btn-link">Logout</button>
					    </form>
					  </div>
					</div>
			  </div>
			</nav>
			@yield('content')
    	</div>
	</div>
	@yield('scripts')
</body>
</html>