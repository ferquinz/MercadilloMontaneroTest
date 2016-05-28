			
			<div id="ListadoProductos" class="row" >
				<?php foreach ($products as $news_products): ?>
					<div id="product-<?php echo $news_products['id']; ?>" class="col-sm-6 col-md-4" >
		    			<div class="thumbnail_ext" >
							<div id="div_img_box_<?php echo $news_products['id']; ?>" >
								<?php 	
										$idimagen = 1;
										$img = explode(",", $news_products['files']);
										foreach ($img as $images): 
											if ($idimagen == 1){ 
								?>
												<a id="img-<?php echo $news_products['id']; ?>-<?php echo $idimagen; ?>" class="img_box thumbnail" href="<?php echo $images; ?>" data-lightbox="image-<?php echo $news_products['id']; ?>" data-title="<?php echo $news_products['title']; ?>" > 
													<div class="hovereffect">
														<img class="img-responsive first" alt="" src="<?php echo str_replace("/basic/", "/thumb/", $images); ?>" ></img>
														<div class="overlay">
															<h2>Precio</h2>
															<p>
																<?php echo $news_products['price']; ?> €
															</p>
														</div>
													</div>	
												</a>
								<?php
								}
								else{
								?>
											<a id="img-<?php echo $news_products['id']; ?>-<?php echo $idimagen; ?>" class="img_box thumbnail" href="<?php echo $images; ?>" data-lightbox="image-<?php echo $news_products['id']; ?>" 
												data-title="<?php echo $news_products['title']; ?>" style="display: none; width: 100%"> 
												<img class="img-responsive" alt="" src="<?php echo str_replace("/basic/", "/thumb/", $images); ?>" ></img>
											</a>	
								<?php
								}
								$idimagen += 1;
								endforeach;
								?>
							</div>
							<div id="descripcion_box_<?php echo $news_products['id']; ?>" class="caption" alt="div_img_box" >
								<h3 style="text-align: center;"><?php echo $news_products['title']; ?></h3>
		        				<p class="cortar" style="text-align: center;">
		        					<label id='lblLugar'>Lugar: </label>
									<span for="Lugar"><?php echo $news_products['place']; ?></span>
								</p>
								<p class="cortar" style="text-align: center;">
		        					<label id='lblContacto'>Contacto: </label>
	        						<?php
										if ($news_products['fbchecked'] == 0){
									?>
										<span for="Contacto"><?php echo $news_products['contact']; ?></span>
									<?php
										}
										else{
									?>
										<span for="Contacto"><?php echo $news_products['fbname']; ?></span>
									<?php
										}
									?>
								</p>						
								<button id="remove" class="btn btn-danger icon-ok hidden-xs" data-id="<?php echo $news_products['id']; ?>" data-toggle="modal" data-target="#deleteModal" alt="button" data-toggle="tooltip" data-placement="bottom" title="Solo para propietarios">Vendido</button>
								<!--<button id="remove" class="btn btn-danger icon-ok hidden-xs" onclick="deleteProduct(<?php echo $news_products['id']; ?>)" alt="button" data-toggle="tooltip" data-placement="bottom" title="Solo para propietarios">Vendido</button>-->
								<span style="margin-left: 10%;" class="hidden-xs">
									<i style="color: #5bc0de; background-color: white; padding-right: 5px " class="glyphicon btn-info glyphicon-eye-open "></i>
									<b><?php echo $news_products['visitas']; ?></b>
								</span> 
								<button class="btn btn-warning" id="btnLeer" onclick="AbrirFicha('<?php echo base_url("FichaProducto"); ?>', <?php echo $news_products['id']; ?>, <?php echo $news_products['visitas']; ?>)" style="float: right;" >Leer Mas<i class="icon-forward"></i></button>								
							</div>
						</div>
					</div>
				<?php 
					$id = $news_products['id'];
					endforeach; ?>
			</div>
			<div class="before col-md-12 text-center"><img style="width: 64px; height: 64px;" src='../img/background/preload.gif' /></div>  
            <div class="lastId" style="display:none" id="<?php echo  $id ?>"></div>
		</div>
	</div>
</section>
<div id="alert_placeholder"></div>
<script>
	
	//actuamos en en evento del scroll
	var scrollLoad = true;
	 
	$(window).scroll(function () { 
	  if (scrollLoad && $(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
	    scrollLoad = false;
	    loadMore();
	  }
	});
	
</script>

