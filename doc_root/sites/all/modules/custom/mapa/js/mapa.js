
   (function($){
   
       Drupal.behaviors.mapa = {
           attach: function() {
  
               //Create a new map variable 
               var map;
               var map_zoom =  $.cookie( 'latitude' ) ? 5 : 3;
               geocoder = new google.maps.Geocoder();
               var markersArray = new Array();
               var contenido_listado = ''; // Para div del listado
               var latitude = $.cookie( 'latitude' ) != null ? $.cookie('latitude')  : 40.416775;
               var longitude = $.cookie( 'longitude' ) != null ? $.cookie('longitude') : -3.70379;
               var center = new google.maps.LatLng(latitude,longitude);
               var geocoder = new google.maps.Geocoder();

               geocode({ 'latLng': center });  
           
  
               if( ($.cookie('geolocated') == null) ){

                   if (navigator.geolocation) {

                             // llamada si geolocation TestMap, llamada si error, TestMap
                             navigator.geolocation.getCurrentPosition( setCoords, TestError, {timeout: 10000, enableHighAccuracy: true, maximumAge: Infinity});
                       }
                   else {
                        alert("Su navegador no soporta geolocalización");
                   }
               }
    showMap ( latitude, longitude, center, map_zoom );
               function setCoords(position){               
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    $.cookie( 'latitude', latitude );
                    $.cookie( 'longitude', longitude );
                    map_zoom = 6;
                    var center = new google.maps.LatLng(latitude,longitude);
                    var geocoder = new google.maps.Geocoder();
                    geocode({ 'latLng': center });      
                    $.cookie( 'geolocated', true );              
                    showMap ( latitude, longitude, center, map_zoom );   
 envio_puntos(0,0, latitude, longitude, map);                
                  
               }

               function geocode(request) {   
                  
                 

                  geocoder.geocode(request, countryInEu);
                }
            
                function countryInEu(results, status){
                    var country = '';
                    for( i in results){
                        if ( $.inArray( 'country', results[i].types ) != - 1 ){
                            country = results[i].address_components[0].short_name;
                        }
                    }
                    var eu_countries = new Array();
                    
                    $( "#edit-pais-origen option" ).each(function(i,item){
                      eu_countries[eu_countries.length] = $(item).val();
                    });
                    if( $.inArray(country, eu_countries) ){
                         $( "#edit-pais-origen" ).val(country);
                        if( $.cookie( 'situated' ) == null ) {
                            $.cookie( 'situated', true );  
                        }
                    };
               }

               function TestError(error){
                 switch(error.code) 
			        {

				        case error.TIMEOUT:
    
					        alert ('Timeout');
					        break;
				        case error.POSITION_UNAVAILABLE:
					        alert ('No se pudo geolocalizar');
					        break;
				        case error.PERMISSION_DENIED:
					        alert ('No ha dado permiso para que obtengamos su posición');
					        break;
				        case error.UNKNOWN_ERROR:
					        alert ('Error desconocido');
					        break;
    			        }



                    var center = new google.maps.LatLng(latitude,longitude);
                    
                    showMap ( latitude, longitude, center, 3 );
                    $.cookie( 'geolocated', false );
               }

               function showMap( latitude, longitude, center, map_zoom ){

                   var mapOptions =
                   {
                       scrollwheel: false,
                       draggable: false,
                       zoom: map_zoom,
                       center:  center,
                       mapTypeControl: false,
                       navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                       mapTypeId: google.maps.MapTypeId.ROADMAP
                   };
   
                   // Crear el mapa y pintar en el div map_canvas
                   map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

	           // you re here
	    
	           var mp = new google.maps.Marker({ 
                                        
                                         map: map,
                                         position: new google.maps.LatLng( center.lat(), center.lng()),
                                         icon: '/sites/all/modules/custom/mapa/js/male-2.png'
                                         // position: results[0].geometry.location 
                                     });
                   if(Drupal.settings.mapa.coordenadas[1]!=0) {
                       var post_origen = Drupal.settings.mapa.coordenadas[0];
                       var post_destino = Drupal.settings.mapa.coordenadas[1];
                        // console.log(Drupal.settings.mapa.coordenadas);
                       $("#edit-pais-origen").val(post_origen);
                       $("#edit-pais-destino").val(post_destino);
                       envio_puntos(post_destino, post_origen, latitude, longitude, map);

                   }
                   else{
                        envio_puntos(0,0, latitude, longitude, map);

                   }
	  	  
               }


             
                   function deleteOverlays() {
                       if (markersArray.length > 0) {
                           for (i in markersArray) {
                               markersArray[i].setMap(null);
                           }
                       }
                   }
                   
                   function anadir_punto(datos_punto, special ) {
                       var pais = '';
                       var address = '';
                       var ciudad = '';
                       var telefono = '';
                       var fax = '';
                       var pais_lat = '';
                       var pais_long = '';
                       var pt_lat  = '';
                       var pt_lng = '';
                       var email = '';
                       var type = '';
                       
                       if (datos_punto.pais != 'null') pais = datos_punto.pais;
                       if (datos_punto.direccion != 'null')address = datos_punto.direccion;
                       if (datos_punto.ciudad != 'null')ciudad = datos_punto.ciudad;
                       if (datos_punto.telefono != 'null')telefono = datos_punto.telefono;
                       if (datos_punto.fax != 'null')fax = datos_punto.fax;
                        if( datos_punto.lng != 0 ) pt_lng = datos_punto.lng;
                       if( datos_punto.lat != 0 ) pt_lat = datos_punto.lat;

                       if( datos_punto.email != 'null' ) email = datos_punto.email;
                       if( datos_punto.type != 'null' ) type = datos_punto.type;
                       	
                    	          if(pt_lat!=0){

                                     var marker = new google.maps.Marker({ 
                                         map: map,
                                         position: new google.maps.LatLng(pt_lat, pt_lng),
                                         icon: '/sites/all/modules/custom/mapa/js/icono-maps.png'
                                         // position: results[0].geometry.location 
                                     });
if( special )
{
	marker.icon = '/sites/all/modules/custom/mapa/js/pin-export.png';
marker.setZIndex(100);
}
var la = $.cookie( 'latitude' ) != null ? $.cookie('latitude')  : 40.416775;
var ln = $.cookie( 'longitude' ) != null ? $.cookie('longitude') : -3.70379;
var link = '<a href="http://maps.google.com/maps?';
link += 'saddr=' + new google.maps.LatLng(la, ln).toUrlValue() + '&', 
link += 'daddr=' + marker.getPosition().toUrlValue() + '" target ="_blank">Cómo llegar<\/a>';
if( address != '' )
{
                                     var infowindow = new google.maps.InfoWindow({
                                       content: '<strong>'+type+'</strong><br/><strong>' + address + '</strong><br /><strong>Teléfono</strong>:' + telefono + '<br /><strong>Fax:</strong> ' + fax + '<br /><strong>Email:</strong><a href="mailto:'+email+'">'+email+'</a><br /> '+ link
                                     });
}
else
{
    var infowindow = new google.maps.InfoWindow({
content:'No existe Consulado ni Embajada de ningún país UE. <br />Teléfonos de emergencia consular: +34 91 394 89 00.<br/> Fuera de horario de oficina +34 91 379 97 00.'});
}
                                     google.maps.event.addListener(marker, 'click', (function() {
				           map.setCenter(marker.getPosition());  
					   map.setZoom(13);
                                           infowindow.open(map, marker);
                                       }
                                   ));


                                     markersArray.push(marker);
if( (map.getBounds()) && ( !map.getBounds().contains(marker.getPosition() ) )){

	var contained = false;
	while( !contained && map.getZoom() > 0 ){
	   map.setZoom( map.getZoom() - 1 );
	   contained = map.getBounds().contains(marker.getPosition() );
	}
}
}


                                    // Se añade la capa al listado siempre, aunque no se localice el punto con geocode
var la = $.cookie( 'latitude' ) != null ? $.cookie('latitude')  : 40.416775;
var ln = $.cookie( 'longitude' ) != null ? $.cookie('longitude') : -3.70379;
if( address != '' ){
                                    var output = '<dt class="titulo"></dt><dd><dl class="detail cl" style="margin-bottom:0"><dt>'+type+'</dt><dd></dd><dt>Dirección postal:</dt><dd>' + address + '</dd><dt><strong>Teléfono:</strong></dt><dd>' + telefono + '</dd><dt><strong>Fax:</strong></dt><dd>' + fax + '</dd><dt><strong>Email:</strong></dt><dd><a href="mailto:"'+email+'">' + email + '</a></dd></dl>';

if( marker ){
output +='<p class="como-llegar">                                                                                <img src="sites/all/modules/custom/mapa/js/m_red.png" alt="" /><a href="http://maps.google.com/maps?saddr=' + new google.maps.LatLng(la, ln).toUrlValue() + '&daddr=' + marker.getPosition().toUrlValue() + '" target ="_blank">Cómo llegar</a></p>'		
}					
			           output += '</dd></dl>';
}
else{
    var output = '<p>No existe Consulado ni Embajada de ningún país UE.<br/> Teléfonos de emergencia consular: +34 91 394 89 00.<br /> Fuera de horario de oficina puede llamar al +34 91 379 97 00.</p>';
}
                                   return output;
                           
                  }
                  
  
              function envio_puntos(siglas, origen, latitude, longitude, map ) {
                 
                  map.setZoom( 5 );
                  if($("#edit-pais-destino").val()!=0) {
                    $("#edit-pais-destino option:selected").each(function (){
                      var address = $(this).text();
                      var siglas = $(this).val();
                      var origen = $('#edit-pais-origen').val();
                      var geocoder = new google.maps.Geocoder();
                      var direccion_pais;
                      geocoder.geocode( { 'address': $( "#edit-pais-destino :selected" ).text()}, 
                                        function(results, status) {
                                            if (status == google.maps.GeocoderStatus.OK) {
                                                map.setCenter(results[0].geometry.location);  
                                              }
                                        });
                     
   $('#no-embajadas').empty();

 deleteOverlays();
                      var contenido_listado = '';
                      $.post(
                          'mapa/get-markers',
                          {paisdestino: siglas, paisorigen: origen,
                          latitude: latitude, longitude: longitude},
                          function(data) {
                 
                            if(data.elements.length) {
                              
                             
                              $.each(data.elements, function(index, value){
                                 if( ( index == 0 ) && value.lat != 0 ) {
                                    map.setCenter(new google.maps.LatLng(value.lat,value.lng) ); 
                                 }
                                 var special = ( index == 0 );

                                 
                                 contenido_listado += anadir_punto(value, special);

                              });
                            if( data.msg ){
                            $('#no-embajadas').html('El Estado miembro de la UE que ha indicado no tiene embajada / consulado de este país no miembro. Como ciudadano de la Unión Europea tiene derecho a la protección de las autoridades consulares de cualquier Estado miembro de la UE de esta lista.');
                            }
                              
                           }
                           else
                           {
                            

                                $('#no-embajadas').html('No existe consulado de ningún país miembro de la UE en este país.');
                           } 
                           if($('#listado-embajadas').length) {
                                      $('.results').css('display', 'block');
                                     
                           }

                           $('#listado-embajadas').html(contenido_listado);
                           }
                           
                       );
                       })}
			else{
			$.post(
                          'mapa/proximos',
                          {paisdestino: siglas, paisorigen: origen,
                          latitude: latitude, longitude: longitude},
                          function(data) {
                 
                            if(data.elements.length) {
                              
                             
                              $.each(data.elements, function(index, value){
                                 if( ( index == 0 ) && value.lat != 0 ) {
                                    map.setCenter(new google.maps.LatLng(value.lat,value.lng) ); 
                                 }
				 var special = ( index == 0 );
                                 
                                 contenido_listado += anadir_punto(value, special);

                              });
                            if( data.msg ){
                            $('#no-embajadas').html('España tiene embajada / consulado en este país no miembro. Como ciudadano de la Unión Europea tiene derecho a la protección de las autoridades consulares de cualquier Estado miembro de la UE.');
                            }
                              
                           }
                           else
                           {
                            

                                $('#no-embajadas').html('España no tiene embajada / consulado en este país no miembro.');
                           } 
                           if($('#listado-embajadas').length) {
                                      $('.results').css('display', 'block');
                                     
                           }

                           $('#listado-embajadas').html(contenido_listado);
                           }
                           
                       );
}

                  }
                  
              function envio_portada() {
                  $("#mapa-buscador-form").attr("action", 'puntos-de-contacto');
                  $("form").submit(function(){
                      var siglas = $(this).val();
                      var origen = $('#edit-pais-origen').val();
                  });
              }
  
              function control_select() {
               $("form").submit(function(){
                  if($('body').hasClass('not-front')) {
                      var latitude = $.cookie( 'latitude' ) != null ? $.cookie('latitude')  : 47.917953;
                      var longitude = $.cookie( 'longitude' ) != null ? $.cookie('longitude') : 13.800327;
                      envio_puntos($('#edit-pais-origen').val(),$('#edit-pais-destino').val(), latitude, longitude, map);
                      return false;
                  }
                });
              }
              
          
         // TestGeo();
          
          control_select();
          
          }
       };

   })(jQuery);


   /* and the check */ 

