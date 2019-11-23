@extends('photofolio::layouts.master')

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-uppercase">{{ $category->title }}</h1>
    <p class="lead">Editando categoria</p>
  </div>
</div>
<div class="container">
	<div class="my-5">
		<el-breadcrumb separator-class="el-icon-arrow-right">
		  <el-breadcrumb-item><a href="{{ route('photofolio.category.index') }}">Categorias</a></el-breadcrumb-item>
		  <el-breadcrumb-item>Editar categoria</el-breadcrumb-item>
		  <el-breadcrumb-item>{{ $category->title }}</el-breadcrumb-item>
		</el-breadcrumb>
	</div>
	<category-edit
		:category="{{ json_encode($category, JSON_UNESCAPED_SLASHES) }}"
		cancel-link="{{ route('photofolio.category.index') }}"
		form-action="{{ route('photofolio.category.update', $category->id) }}"
	></category-edit>
</div>
@endsection