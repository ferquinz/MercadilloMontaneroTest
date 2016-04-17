<script type="text/javascript">
	FileAPI = {
		debug : true,
		//forceLoad: true, html5: false //to debug flash in HTML5 browsers
		//wrapInsideDiv: true, //experimental for fixing css issues
		//only one of jsPath or jsUrl.
		//jsPath: '/js/FileAPI.min.js/folder/',
		//jsUrl: 'yourcdn.com/js/FileAPI.min.js',

		//only one of staticPath or flashUrl.
		//staticPath: '/flash/FileAPI.flash.swf/folder/'
		//flashUrl: 'yourcdn.com/js/FileAPI.flash.swf'
	}; 
	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip(
		{
		    html: true,
		    container: 'body'
		  });
		});

	
</script>

<section id="gallery">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xs-12">
				<h1 class="page-header"><?php echo $pagina; ?>
				<?php if ($tipolistado != 7){ ?>
				<!--<form role="form" method="post" action="<?php echo site_url('listado/ajax_filter')?>">-->
					<div class="center_center hidden-xs filter" style="display: inline-table; position: sticky;">
						<input name="filtro" type="text" class="form-control" placeholder="Filtrar Productos" onchange="filterProduct(this.value)" ></input>
						<!--<input type="text" class="form-control" placeholder="Filtrar Productos" onchange="filterProduct(this.value, <?php echo $tipolistado; ?>)" ></input>-->
						<!--<input type="text" name="filter" class="form-control" placeholder="Filtrar Productos" style="display: inline; width: 85%" ></input>-->
						<!--<button type="submit" class="form-control btn-primary" alt="input" style="display: inline; width: 15%">Buscar</button>-->					
					</div>
				<!--</form>-->
				
				<div id="btnNuevo" >
					<a type="button" class="btn btn-success hvr-sweep-to-right" data-toggle="modal" data-target="#myModalForm"> <i class="icon-plus-circle"></i> Nuevo </a>
				</div></h1>
				<?php } ?>
			</div>