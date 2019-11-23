@extends('photofolio::layouts.master')

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-uppercase">Criar categoria</h1>
    <p class="lead">Adicione uma nova categoria.</p>
  </div>
</div>
<div class="container">
	<div class="my-5">
		<el-breadcrumb separator-class="el-icon-arrow-right">
		  <el-breadcrumb-item><a href="{{ route('photofolio.category.index') }}">Categorias</a></el-breadcrumb-item>
		  <el-breadcrumb-item>Criar categoria</el-breadcrumb-item>
		</el-breadcrumb>
	</div>
	<category-create
		cancel-link="{{ route('photofolio.category.index') }}"
		form-action="{{ route('photofolio.category.store') }}"
	></category-create>
</div>
@endsection