@extends('photofolio::layouts.master')

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-uppercase">Categorias</h1>
    <p class="lead">Liste, crie e edite, delete categorias.</p>
    <a href="{{ route('photofolio.category.create') }}">
    	<el-button type="primary" plain>Criar categoria</el-button>
    </a>
  </div>
</div>
<div class="container">
  <div class="my-5">
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item><a href="{{ route('photofolio.category.index') }}">Categorias</a></el-breadcrumb-item>
      <el-breadcrumb-item>Todas as Categorias</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
	<category-list
		:categories="{{ json_encode($categories, JSON_UNESCAPED_SLASHES) }}"
		edit-url="{{ route('photofolio.category.edit', '@category_id') }}"
		delete-url="{{ route('photofolio.category.destroy', '@category_id') }}"
	></category-list>
</div>
@endsection