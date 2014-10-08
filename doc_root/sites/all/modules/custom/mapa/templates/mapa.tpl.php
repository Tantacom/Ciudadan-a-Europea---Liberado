<section class="main">
  <h2 class="contact">Puntos de contacto</h2>
  <section id="intro">
    <p>El <a href="http://europa.eu/lisbon_treaty/index_es.htm" target="_blank">Tratado de Lisboa</a> entró en vigor el 1 de Diciembre de 2009. Su objetivo es actualizar el funcionamiento de las instituciones europeas para responder a los nuevos retos y promover los intereses de sus ciudadanos. Entre otras cosas, asegura la asistencia consular o diplomática a cualquier ciudadano europeo que se encuentre fuera de la UE.</p>

<p>Esta web y su versión móvil se han creado para proporcionar a cualquier español, en todo momento, la información necesaria para que sepa a dónde dirigirse para obtener ese apoyo consular.</p>
  </section>
  <article class="contact">
       <section>
          <div class="map  cl <?php if(!drupal_is_front_page()) { ?>all<?php } ?>">
              
            <?php print render(drupal_get_form('mapa_buscador_form')); ?>
              
          <div class="cont-map clearfix">
                  <div id="map_canvas"></div>
          </div>

         <div class="legend cl">
										<b>Leyenda:</b>
										<ul>
											<li><span class="ico"><img src="sites/all/modules/custom/mapa/js/m_red.png" alt="" /></span> <span>Punto de contacto</span></li>
											<li><span class="ico"><img src="sites/all/modules/custom/mapa/js/m_nearest.png" alt="" /></span> <span>Punto de contacto <br />más cercano</span></li>
											<li class="middle"><span class="ico"><img src="sites/all/modules/custom/mapa/js/m_position.png" alt="" /></span> <span>Tu posición actual</span></li>
											<li class="middle"><span class="ico"><img src="sites/all/modules/custom/mapa/js/m_zoom.png" alt="" /></span> <span>Ampliar / reducir zoom del mapa</span></li>
										</ul>
									</div>
        </div>
      </section>
  </article>
</section>
<?php
if(isset($_SESSION['coordenadaspost']) && count($_SESSION['coordenadaspost']) > 0) {
    drupal_add_js(array('mapa' => array('coordenadas' => $_SESSION['coordenadaspost'])), 'setting');
    unset($_SESSION['coordenadaspost']);
} else  {
    drupal_add_js(array('mapa' => array('coordenadas' => array(0, 0))), 'setting');
} ?>
<?php if(!drupal_is_front_page()) { ?>

<section class="results">
  <div class="sep">&nbsp;</div>
  <h3 class="contact">Representaciones diplomáticas y consulares en el país elegido</h3>
  <div class="wysiwyg">
    <p id="no-embajadas"></p>
    <dl id="listado-embajadas"></dl>
  </div>
</section>
<?php } ?>
