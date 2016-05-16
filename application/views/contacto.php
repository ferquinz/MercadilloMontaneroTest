<div id="main">
	<div id="content">
		<section class="module parallax parallax-1">
			<p>
				<em>"Gredos, montaña sagrada,
				que se toca de la pureza blanca de la nieve
				para guardar su corazón de piedra berroqueña
				eterno como la fuerza del espíritu
				que desafia el tiempo y cambia los destinos"</em>
			</p>
			<div class="container">
				<!--<h1>Serene</h1>-->
			</div>
		</section> 

		<section class="module content">
			<div class="container">
				<!--<div class="row">
					<div class="col-md-12 normal-column">
						<div class="blank-divider" style="height: 100px;"></div>
					</div>
				</div>-->
				<h2>Envíanos tu sugerencia</h2>
				<div class="row">
					<div class="col-md-12 normal-column">
						<form action="#" name="emailform" id="emailform" method="post" enctype="multipart/form-data" accept-charset="utf-8">
							<div class="modal-body">
								<div class="form-group" >
									<label for="recipient-title" class="control-label">Tu nombre (Campo Obligatorio)</label>
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required size="50" required />
								</div>
								<div class="form-group" >
									<label for="recipient-title" class="control-label">Tu correo (Campo Obligatorio)</label>
									<input type="text" class="form-control" id="email" name="email" placeholder="Email" required size="50" required/>
								</div>
								<div class="form-group" >
									<label for="recipient-title" class="control-label">Asunto</label>
									<input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto" required size="50" />
								</div>
								<div class="form-group" >
									<label for="recipient-title" class="control-label">Tu Mensaje</label>
									<textarea type="text" cols="40" rows="10" class="form-control" id="mensaje" name="mensaje" placeholder="Escribe aqui tu sugerencia, error o enlace si quieres que pongamos tu timelapse al inicio" required size="50"></textarea>
								</div>
							</div>
							<div id="successMessage" class="success" style="display:none; color: green;" >Mensaje enviado correctamente</div>
							<div id="errorMessage" class="error" style="display:none; color: red;" >Error al enviar el mensaje. Envíelo a la dirección: mercadillomontanero@gmail.com</div>
							<div class="modal-footer">
								<div style="float: left;">
									<a style="float: left;" href="https://www.wetransfer.com/" target="_blank">
										<span>
											<i class="glyphicon glyphicon-transfer"></i> Enviar datos adjuntos
										</span>
									</a>
									<div>
										mercadillomontanero@gmail.com
									</div>
								</div>
								<button type="submit" value="Enviar" class="btn btn-success">Enviar</button>
							</div>
						</form>
					</div>
				</div>
				<!--<h2>Lorem Ipsum Dolor</h2>
				<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit...
				</p>-->
			</div>
		</section>

		<section class="module parallax parallax-2">
			<div class="container">
				<h2>"No puedo imaginarme descendiendo derrotado de la montaña ... "</h2>
				<h3 style="text-align: right; color: rgba(255, 255, 255, 0.8);">George Mallory</h3>
			</div>
		</section>

		<section class="module content">
			<div class="container">

				<h2>Lugar de entrenamiento</h2>
				<p>
					Sitios del barrio donde poder entrenar al aire libre.
				</p>
			</div>
		</section>

		<section class="module parallax parallax-3">
			<div id="map" class="map"></div>
			<div id="popup" class="ol-popup">
			  	<a href="#" id="popup-closer" class="ol-popup-closer"></a>
			  	<div id="popup-content"></div>
			</div>
		</section>

		<!--<section class="module content">
		<div class="container">
		<h2>Lorem Ipsum Dolor</h2>
		<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit...
		</p>
		</div>
		</section>-->

		<script>
		
			/**
			 * Elements that make up the popup.
			 */
			var container = document.getElementById('popup');
			var content = document.getElementById('popup-content');
			var closer = document.getElementById('popup-closer');
		
			/**
			 * Add a click handler to hide the popup.
			 * @return {boolean} Don't follow the href.
			 */
			closer.onclick = function() {
			  overlay.setPosition(undefined);
			  closer.blur();
			  return false;
			};
			
			
			/**
			 * Create an overlay to anchor the popup to the map.
			 */
			var overlay = new ol.Overlay({
			  element: container,
			  autoPan: true,
			  autoPanAnimation: {
			    duration: 250
			  }
			});
		
			function createStyle(src, img) {
		        return new ol.style.Style({
		          image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
		            anchor: [0.5, 0.96],
		            src: src,
		            img: img,
		            imgSize: img ? [img.width, img.height] : undefined
		          }))
		        });
		      }

			var muro = new ol.Feature({
        		geometry: new ol.geom.Point(ol.proj.transform([-3.698660,40.485245], 'EPSG:4326', 'EPSG:3857')),
        		name: 'Muro',
      		});
			muro.set('style', createStyle('<?php echo base_url() ?>img/marker-icon.png', undefined));
			
      		var tunel = new ol.Feature({
        		geometry: new ol.geom.Point(ol.proj.fromLonLat([-3.697573,40.494624])),
        		name: 'Tunel',
      		});
      		tunel.set('style', createStyle('<?php echo base_url() ?>img/marker-icon.png', undefined));
      		
      		var iconStyle = new ol.style.Style({
	        	image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
		          	anchor: [0.5, 0.96],
		          	anchorXUnits: 'fraction',
		          	anchorYUnits: 'pixels',
		          	src: '<?php echo base_url() ?>img/marker-icon.png'
		        }))
	      	});
			
			var vectorSource = new ol.source.Vector({
        		features: [muro, tunel]
      		});

      		var vectorLayer = new ol.layer.Vector({
      			style: function(feature) {
	              return feature.get('style');
	            },
        		source: vectorSource
      		});
      		
			var map = new ol.Map({
				interactions: ol.interaction.defaults({mouseWheelZoom:false}),
			  	view: new ol.View({
		    		center: ol.proj.transform([-3.707524, 40.485644], 'EPSG:4326', 'EPSG:3857'),
				    zoom: 15,
				    maxZoom: 18,
				    minZoom: 6
			  	}),
			  	overlays: [overlay],
			  	layers: [
			    	new ol.layer.Tile({
			      		source: new ol.source.MapQuest({layer: 'osm'})
			    	}),
			    	vectorLayer
			  	],
			  	target: 'map'
			});
			
			/**
			 * Add a click handler to the map to render the popup.
			 */
			map.on('singleclick', function(evt) {
			  var name = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
			    return feature.get('name');
			  })
			  if(name != null){
			  	var coordinate = evt.coordinate;
			  	content.innerHTML = name;
			  	overlay.setPosition(coordinate);
			 }
			});
			map.on('pointermove', function(evt) {
			  map.getTargetElement().style.cursor = map.hasFeatureAtPixel(evt.pixel) ? 'pointer' : '';
			});
			
		</script>
	</div>
</div>