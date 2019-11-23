@extends('photofolio::layouts.master')

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-uppercase">Portifólios</h1>
    <p class="lead">Liste, crie e edite, delete portifólios.</p>
    <a href="{{ route('photofolio.portifolio.create') }}">
    	<el-button type="primary" plain>Criar portifólio</el-button>
    </a>
  </div>
</div>
<div class="container">
  <div class="my-5">
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="{{ route('photofolio.portifolio.index') }}">Portifólios</a></el-breadcrumb-item>
      <el-breadcrumb-item>Todos os Portifólios</el-breadcrumb-item>      
    </el-breadcrumb>
  </div>
	<portifolio-list
		:portifolios="{{ json_encode($portifolios, JSON_UNESCAPED_SLASHES) }}"
		edit-url="{{ route('photofolio.portifolio.edit', '@portifolio_id') }}"
		delete-url="{{ route('photofolio.portifolio.destroy', '@portifolio_id') }}"
	></portifolio-list>
</div>
@endsection