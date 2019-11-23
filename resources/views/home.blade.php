@extends('photofolio::layouts.master')

@section('content')
	@php
		function geeting( $time ) {
			if ($time < "12") {
		        echo "Bom dia";
		    } else
		    if ($time >= "12" && $time < "18") {
		        echo "Boa Tarde";
		    } else
		    if ($time >= "18") {
		        echo "Boa Noite";
		    }
		}

		function format_bytes( $bytes ) {
			$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		    $base = 1024;
		    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		    return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
		}

		function map($value, $fromLow, $fromHigh, $toLow, $toHigh) {
		    $fromRange = $fromHigh - $fromLow;
		    $toRange = $toHigh - $toLow;
		    $scaleFactor = $toRange / $fromRange;
		    $tmpValue = $value - $fromLow;
		    $tmpValue *= $scaleFactor;
		    return $tmpValue + $toLow;
		}
	@endphp
	<div class="jumbotron jumbotron-fluid">
	  <div class="container">
	    <h1 class="display-4 text-uppercase"> {{ geeting(date("H")) }}, {{ \Auth::user()->name }}</h1>
	    <p class="lead">Aqui estão algumas métricas sobre seu site.</p>
	  </div>
	</div>
	<div class="container">
		<div class="my-5">
			<el-breadcrumb separator-class="el-icon-arrow-right">
			  <el-breadcrumb-item><a href="{{ route('photofolio.dashboard') }}">Dashboard</a></el-breadcrumb-item>
			  <el-breadcrumb-item>Visão geral</el-breadcrumb-item>
			</el-breadcrumb>
		</div>
		<div class="row">
			<div class="col-12 col-md-4">
				<el-card shadow="hover" class="h-100">
					<div slot="header" class="clearfix">
					    <span><b>Espaço em disco disponível</b></span>
					</div>
					<div class="text-center">
						@php
							$free_space = disk_free_space(__DIR__) - 524288000;
							$total_space = disk_total_space(__DIR__) - 524288000;
							function get_space_status( $free_space, $total_space ){
								if( $free_space > ( $total_space / 2 ) )
									return 'success';
								else if ( $total_space - $free_space < 1000000000 )
									return 'exception';
								else
									return 'warning';
							}
						@endphp
						<el-progress type="dashboard" :percentage="{{ map($free_space, 0, $total_space, 100, 0) }}" status="{{ get_space_status($free_space, $total_space) }}"></el-progress>
					</div>
					<div class="text-center">
						<b>Espaço Livre</b><br>
						{{ format_bytes($free_space) }} / <span class="text-muted">{{ format_bytes($total_space) }}</span>
					</div>
				</el-card>
			</div>
			<div class="col-12 col-md-4">
				<el-card shadow="hover" class="h-100">
					<div slot="header" class="clearfix">
					    <span><b>Quantidade de portifólios</b></span>
					</div>
					<div class="text-center">
						<el-progress type="dashboard" :percentage="100" status="success"></el-progress>
					</div>
					<div class="text-center">
						<b>Criados</b><br>
						{{ $portifolio_item_count }} / <span class="text-muted">&infin; Ilimitado</span>
					</div>
				</el-card>
			</div>
			<div class="col-12 col-md-4">
				<el-card shadow="hover" class="h-100">
					<div slot="header" class="clearfix">
					    <span><b>Quantidade de fotos</b></span>
					</div>
					<div class="text-center">
						<el-progress type="dashboard" :percentage="100" status="success"></el-progress>
					</div>
					<div class="text-center">
						<b>Armazenadas</b><br>
						{{ $portifolio_item_count }} / <span class="text-muted">&infin; Ilimitado</span>
					</div>
				</el-card>
			</div>
		</div>
	</div>
@endsection