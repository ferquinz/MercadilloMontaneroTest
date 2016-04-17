<script>
	
	/*$(document).ready(function(){
		
		console.log("Altura cuerpo: " + $("#cuadro_producto").height());
		console.log("Altura cabecera: " + $(".ficha_cabecera").height());	
		console.log("Altura iframe: " + $(".fancybox-iframe").height());	
		console.log("Altura iframe: " + $('#fancybox-content').contents().height());
		console.log("Altura iframe: " + $("body").height());
		console.log("Altura iframe: " + $('.fancybox-iframe').contents().find('html').height());
		
	});*/
	
</script>


<body style="overflow: hidden">
	<?php foreach ($product_data as $producto): ?>
	<header class="ficha_cabecera">
		<h4 style="color: white;">
			<?php echo $producto['title']; ?>
			<button type="button" class="close larger" aria-label="Close" style="float: right; color: white;" onclick="javascript:parent.jQuery.fancybox.close();">
				<span aria-hidden="true">&times;</span>
			</button>
		</h4>
	</header>
	<div id="cuadro_producto" class="row" style="padding: 10px; width: 100%;">
		<div class="col-md-7 col-xs-12 col-sm-7 img-responsive hidden-xs" >
			<?php 	
					$idimagen = 1;
					$img = explode(",", $producto['files']);
					foreach ($img as $images): 
						if ($idimagen == 1){ 
			?>
			<div class="img_container">
				<img id="img_01" src="<?php echo $images;?>" data-zoom-image="<?php echo $images;?>" class="img-responsive" />
			</div>
			<div id="gal1">
				<a href="#" class="elevatezoom-gallery active" data-update="" data-image="<?php echo $images;?>" data-zoom-image="<?php echo $images;?>"> 
					<img src="<?php echo str_replace("/basic/", "/thumb/", $images);?>" class="img_gal1" /> 
				</a>
			<?php 		
						}
						else{ 
			?>
			 
				<a href="#" class="elevatezoom-gallery img_gal1" data-update="" data-image="<?php echo $images;?>" data-zoom-image="<?php echo $images;?>"> 
					<img src="<?php echo str_replace("/basic/", "/thumb/", $images);?>" class="img_gal1" /> 
				</a> 			
			<?php 	
						}
						$idimagen += 1;
					endforeach; 
			?> 
			</div>
		</div>
		<div class="col-md-5 col-xs-5">
			<h2><?php echo $producto['title']; ?></h2>
			<div class="product-info">
				<div class="product-info-data">
					<dt>Lugar : </dt>
					<dd><?php echo $producto['place']; ?></dd>
				</div>
				<div class="product-info-data">
					<dt>Precio : </dt>
					<dd style="font-size: 22px; color: #FF8F5F;"><?php echo $producto['price']; ?> €</dd>
				</div>
				<div class="product-info-data">
					<dt>Contacto : </dt>
					<?php
						if ($producto['fbchecked'] == 0){
					?>
					<dd><?php echo $producto['contact']; ?></dd>
					<?php
						}
						else{
					?>
						<dd>
							<!--<input type="button" class="icon-facebook-rect btn btn-primary" onclick="location.href='http://www.facebook.com/profile.php?id=<?php echo $producto['contact']; ?>;"><i class="icon-facebook-rect gi-2x"></i></input>-->
							<a target="_blank" href="http://www.facebook.com/profile.php?id=<?php echo $producto['contact']; ?>" class="btn btn-primary icon-facebook-rect gi-2x"> <?php echo $producto['fbname']; ?></a>
						</dd>
					<?php
						}
					?>
				</div>
				<div class="product-info-data">
					<dt>Descripción : </dt>
					<dd><?php echo $producto['description']; ?></dd>
				</div>
				<div class="product-info-data">
					<dt>Visitas : </dt>
					<dd>
						<i style="color: #5bc0de; background-color: white; padding-right: 5px " class="glyphicon btn-info glyphicon-eye-open "></i>
						<b><?php echo $producto['visitas']; ?></b>
					</dd>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	
	<script>
	
		//initiate the plugin and pass the id of the div containing gallery images 
		var zoomConfig = {cursor: 'crosshair', zoomType: "lens",lensShape : "round", lensSize : 200, galleryActiveClass: 'active', gallery: 'gal1'}; 
		var image = $('#gal1 a');
		var zoomImage = $('img#img_01');
		
		zoomImage.elevateZoom(zoomConfig);//initialise zoom
		
		image.on('click', function(){
		    // Remove old instance od EZ
		    $('.zoomContainer').remove();
		    zoomImage.removeData('elevateZoom');
		    // Update source for images
		    zoomImage.attr('src', $(this).data('image'));
		    zoomImage.data('zoom-image', $(this).data('zoom-image'));
		    // Reinitialize EZ
		    zoomImage.elevateZoom(zoomConfig);
		});
		
		$("#img_01").bind("click", function(e) { 
			var ez = $('#img_01').data('elevateZoom');	
			$.fancybox(ez.getGalleryList()); return false; 
		}); 
		
	</script>
</body>
