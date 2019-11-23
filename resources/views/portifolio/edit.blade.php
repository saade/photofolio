@extends('photofolio::layouts.master')

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-uppercase">{{ $portifolio->title }}</h1>
    <p class="lead">Editando portifólio</p>
  </div>
</div>
<div class="container">
	<div class="my-5">
	    <el-breadcrumb separator-class="el-icon-arrow-right">
	      <el-breadcrumb-item><a href="{{ route('photofolio.portifolio.index') }}">Portifólios</a></el-breadcrumb-item>
	      <el-breadcrumb-item>Editar portifólio</el-breadcrumb-item>      
	      <el-breadcrumb-item>{{ $portifolio->title }}</el-breadcrumb-item>      
	    </el-breadcrumb>
	  </div>
	<portifolio-edit
		:portifolio="{{ json_encode($portifolio, JSON_UNESCAPED_SLASHES) }}"
		:categories="{{ json_encode($categories, JSON_UNESCAPED_SLASHES) }}"
		cancel-link="{{ route('photofolio.portifolio.index') }}"
		form-action="{{ route('photofolio.portifolio.update', $portifolio->id) }}"
	></portifolio-edit>
	<hr class="my-5">
	<h4 class="title text-uppercase">Adicionar Imagens</h4>
	<portifolio-upload
		class="mt-5"
		form-action="{{ route('photofolio.portifolio.item.store', $portifolio->id) }}"
	></portifolio-upload>
	<hr class="my-5">
	<h4 class="title text-uppercase">Suas Imagens</h4>
	<small class="text-muted"><i class="el-icon-info"></i> Você pode definir uma foto oculta como capa.</small>

	<div class="photofolio-gallery mt-5">
		@foreach($portifolioItems as $item)
		<div class="image image--{{ $item->grid_layout == 'random' ? ['portrait', 'landscape', 'square', 'big-square'][rand(0,3)]: $item->grid_layout }}{{ $item->is_cover ? ' image--selected' : '' }}{{ $item->is_hidden ? ' image--hidden' : '' }}">
			<img class="lazy-image" data-src="{{ $item->full_url }}">
			<div class="photofolio-gallery--actions">
				<span class="photofolio-gallery--item-actions">
	              <span>
	              	<el-tooltip :enterable="false" class="item" effect="dark" content="Visualizar" placement="top-start">
				      	<a href="{{ $item->full_url }}" class="glightbox">
		              		<i class="el-icon-zoom-in"></i>
		              	</a>
				    </el-tooltip>
	              </span>
	              <span>
	              	<portifolio-item--set-cover
	              		:is_cover="{{ $item->is_cover }}"
	              		edit-url="{{ route('photofolio.portifolio.item.update', [ $portifolio->id, $item->id ]) }}">
	              	</portifolio-item--set-cover>
	              </span>
	              <span>
	              	<portifolio-item--set-hidden
	              		:is_hidden="{{ $item->is_hidden }}"
	              		edit-url="{{ route('photofolio.portifolio.item.update', [ $portifolio->id, $item->id ]) }}">
	              	</portifolio-item--set-hidden>
	              </span>
	              <span>
	              	<portifolio-item--change-layout
	              		layout="{{ $item->grid_layout }}"
	              		edit-url="{{ route('photofolio.portifolio.item.update', [ $portifolio->id, $item->id ]) }}">
	              	</portifolio-item--change-layout>
	              </span>
	              <span class="m-0"></span>
	              <span>
	              	<portifolio-item--delete
	              		delete-url="{{ route('photofolio.portifolio.item.destroy', [ $portifolio->id, $item->id ]) }}">
	              	</portifolio-item--delete>
	              </span>
	            </span>
	        </div>
		</div>
		@endforeach
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', () => {
		let images = [...document.querySelectorAll('.lazy-image')]

		const interactSettings = {
		  rootMargin: '0px 0px 200px 0px'
		}

		function onIntersection(imageEntites) {
		  imageEntites.forEach(image => {
		    if (image.isIntersecting) {
		      observer.unobserve(image.target)
		      image.target.src = image.target.dataset.src
		      image.target.onload = () => image.target.classList.add('loaded')
		    }
		  })
		}

		let observer = new IntersectionObserver(onIntersection, interactSettings)
		images.forEach(image => observer.observe(image))
	})
</script>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		const lightbox = GLightbox();
	});
</script>
@endsection