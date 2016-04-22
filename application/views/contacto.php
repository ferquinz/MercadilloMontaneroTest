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
			<div id="map"></div>
			<!--<div class="container">
			<h1>Calm</h1>
			</div>-->
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
			var map;
			function initMap() {
				map = new google.maps.Map(document.getElementById('map'), {
					center : {
						lat : 40.485644,
						lng : -3.707524
					},
					zoom : 15,
					scrollwheel : false,
					navigationControl : false,
					mapTypeControl : false,
					scaleControl : false,
					draggable : false,
					mapTypeId : google.maps.MapTypeId.ROADMAP
				});
				/* MURO */
				var infowindow = new google.maps.InfoWindow({
					content : "Muro"
				});
				marker = new google.maps.Marker({
					map : map,
					draggable : false,
					animation : google.maps.Animation.DROP,
					position : {
						lat : 40.485245,
						lng : -3.698660
					}
				});
				marker.addListener('click', toggleBounce);
				marker.addListener('click', function() {
					infowindow.open(map, marker);
				});
				infowindow.open(map, marker);
				/* TUNEL */
				var infowindow1 = new google.maps.InfoWindow({
					content : "Tunel"
				});
				marker1 = new google.maps.Marker({
					map : map,
					draggable : false,
					animation : google.maps.Animation.DROP,
					position : {
						lat : 40.494624,
						lng : -3.697573
					}
				});
				marker1.addListener('click', toggleBounce);
				marker1.addListener('click', function() {
					infowindow1.open(map, marker1);
				});
				infowindow1.open(map, marker1);
			}

			function toggleBounce() {
				if (marker.getAnimation() !== null) {
					marker.setAnimation(null);
				} else {
					marker.setAnimation(google.maps.Animation.BOUNCE);
				}
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
	</div>
</div>