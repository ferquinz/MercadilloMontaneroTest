<nav class="navbar navbar-tabs navbar-fixed-top" data-spy="affix" data-offset-top="195">
	<div class="container-fluid">
		<div id="logo" class="navbar-header">
			<a href="<?php echo site_url('inicio'); ?>">
			<span class="logo_header" disabled="disabled"> 
				<i class="icon-map"></i> 
				Mercadillo Montañero 
			</span>
			</a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="background-color: #337ab7;">
		        <span class="icon-bar" style="background-color: white;"></span>
		        <span class="icon-bar" style="background-color: white;"></span>
		        <span class="icon-bar" style="background-color: white;"></span>                        
		      </button>
		</div>
		<div class="collapse navbar-collapse navbar-right navbar-main-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li>
					<a href="<?php echo site_url('inicio'); ?>"><?php echo ($tipolistado = 0) ? 'navactive' : ''; ?>Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categorias <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo site_url('listado/1'); ?>">Ropa</a>
						</li>
						<li>
							<a href="<?php echo site_url('listado/2'); ?>">Calzado</a>
						</li>
						<li>
							<a href="<?php echo site_url('listado/3'); ?>">Material</a>
						</li>
						<li>
							<a href="<?php echo site_url('listado/4'); ?>">Accesorios</a>
						</li>
						<li>
							<a href="<?php echo site_url('listado/5'); ?>">Camping</a>
						</li>
						<li>
							<a href="<?php echo site_url('listado/6'); ?>">Otros</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="<?php echo site_url('listado/7'); ?>">Novedades</a>
				</li>
				<li>
					<a href="<?php echo site_url('contacto'); ?>">Contacto</a>
				</li>
			</ul>
		</div>
	</div>
</nav>