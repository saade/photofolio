@extends('photofolio::layouts.master')

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-uppercase">Criar portifólio</h1>
    <p class="lead">Adicione um novo item á sua galeria.</p>
  </div>
</div>
<div class="container">
	<div class="my-5">
	    <el-breadcrumb separator-class="el-icon-arrow-right">
	      <el-breadcrumb-item><a href="{{ route('photofolio.portifolio.index') }}">Portifólios</a></el-breadcrumb-item>
	      <el-breadcrumb-item>Criar portifólio</el-breadcrumb-item>      
	    </el-breadcrumb>
	  </div>
	<portifolio-create
		:categories="{{ json_encode($categories, JSON_UNESCAPED_SLASHES) }}"
		cancel-link="{{ route('photofolio.portifolio.index') }}"
		form-action="{{ route('photofolio.portifolio.store') }}"
		redirect-url="{{ route('photofolio.portifolio.edit', '@portifolio_id') }}"
	></portifolio-create>
</div>
@endsection