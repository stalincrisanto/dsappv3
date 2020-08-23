<?php
  if(isset($_POST["registro_vendedor"]) && ($_POST["registro_vendedor"]=="Registrar"))
  {
    $imagen = $_FILES['imagen_local']['name'];
    $archivo = $_FILES['imagen_local']['tmp_name'];
    $ruta = "images/".$imagen;
    move_uploaded_file($archivo,$ruta);
    include './services/serviciosVendedor.php';
    insertarVendedor($_POST["nombre_local"],$_POST["direccion_local"],$_POST["telefono_local"],$ruta,
    $_POST["nombre_propietario"],$_POST["apellido_propietario"],$_POST["email_propietario"],$_POST["contraseña"],
    $_POST["categoria"],$_POST['lat'],$_POST['lng']);
    header("location: index2.php");
  }
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar Vendedor</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts_registro/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css_registro/style.css">

</head>
<body>

    <div class="main">
        <div class="container">
            <div class="signup-content">
                <div class="signup-img">
                    <br><br><img src="images/signup-img.jpg" alt="">
                </div>
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                        <h2>Registrar Nuevo Vendedor</h2>
                        <div class="form-group">
                            <label for="nombre_local">Nombre del Local:</label>
                            <input type="text" name="nombre_local" placeholder="Ingrese el nombre del Local" required/>
                        </div>
                        <!--<div class="form-group">
                            <label for="direccion_local">Dirección del Local:</label>
                            <input type="text" name="direccion_local" placeholder="Ingrese la dirección del Local" required/>
                        </div>-->

                        <!--PRUEBA DE MAPAS-->
                        <div class="form-grup">
                            <label for="direccion_local">Dirección del Local:</label>
                            <input type="text" name="direccion_local" placeholder="Ingrese la dirección del Local" required/>
                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lng" name="lng">
                        </div><br>

                        <style>
                            #map{position:absolute;left: 730px; top:290px; bottom:0px;height:250px ;width:660px;}
                            .geododer{position:absolute;left: 350px; top:290px;}                            
                        </style>
                        <div class="geocoder">
                            <div id="geocoder" >

                            </div>
                        </div>

                        <div class="form-group"  id="map"></div>

                        <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.js'></script>
                        <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.css' rel='stylesheet' />
                        <style>
                        </style>

                        <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
                        <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css' type='text/css' />

                        <script>

                            var user_location = [-78.4718548,-0.3357266];
                            mapboxgl.accessToken = 'pk.eyJ1Ijoic3RhbGluY3Jpc2kiLCJhIjoiY2tlMWd5MTVhMzJpdjJ0bnVrOHZhcTdwbiJ9.6V4Nvc467d0SOgd7OinkZA';
                            //mapboxgl.accessToken = 'pk.eyJ1IjoiZmFraHJhd3kiLCJhIjoiY2pscWs4OTNrMmd5ZTNra21iZmRvdTFkOCJ9.15TZ2NtGk_AtUvLd27-8xA';
                            var map = new mapboxgl.Map({
                                container: 'map',
                                style: 'mapbox://styles/mapbox/streets-v9',
                                center: user_location,
                                zoom: 10
                            });
                            //  geocoder here
                            var geocoder = new MapboxGeocoder({
                                accessToken: mapboxgl.accessToken,
                                // limit results to Australia
                                //country: 'IN',
                            });

                            var marker ;

                            // After the map style has loaded on the page, add a source layer and default
                            // styling for a single point.
                            map.on('load', function() {
                                addMarker(user_location,'load');
                                //add_markers(saved_markers);

                                // Listen for the `result` event from the MapboxGeocoder that is triggered when a user
                                // makes a selection and add a symbol that matches the result.
                                geocoder.on('result', function(ev) {
                                    alert("aaaaa");
                                    console.log(ev.result.center);

                                });
                            });
                            map.on('click', function (e) {
                                marker.remove();
                                addMarker(e.lngLat,'click');
                                //console.log(e.lngLat.lat);
                                document.getElementById("lat").value = e.lngLat.lat;
                                document.getElementById("lng").value = e.lngLat.lng;

                            });

                            function addMarker(ltlng,event) {

                                if(event === 'click'){
                                    user_location = ltlng;
                                }
                                marker = new mapboxgl.Marker({draggable: true,color:"#d02922"})
                                    .setLngLat(user_location)
                                    .addTo(map)
                                    .on('dragend', onDragEnd);
                            }
                            function add_markers(coordinates) {

                                var geojson = (saved_markers == coordinates ? saved_markers : '');

                                console.log(geojson);
                                // add markers to map
                                geojson.forEach(function (marker) {
                                    console.log(marker);
                                    // make a marker for each feature and add to the map
                                    new mapboxgl.Marker()
                                        .setLngLat(marker)
                                        .addTo(map);
                                });

                            }

                            function onDragEnd() {
                                var lngLat = marker.getLngLat();
                                document.getElementById("lat").value = lngLat.lat;
                                document.getElementById("lng").value = lngLat.lng;
                                console.log('lng: ' + lngLat.lng + '<br />lat: ' + lngLat.lat);
                            }

                            /**$('#signupForm').submit(function(event){
                                event.preventDefault();
                                var lat = $('#lat').val();
                                var lng = $('#lng').val();
                                var url = 'locations_model.php?add_location&lat=' + lat + '&lng=' + lng;
                                $.ajax({
                                    url: url,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(data){
                                        alert(data);
                                        location.reload();
                                    }
                                });
                            });**/
                            

                            document.getElementById('geocoder').appendChild(geocoder.onAdd(map));

                        </script>

                        <!--FIN PRUEBA MAPAS-->
            
                        <br><br><br><br><br><br><br><br><br><br><br>
                        <div class="form-group">
                            <label for="telefono_local">Teléfono del Local:</label>
                            <input type="text" name="telefono_local" placeholder="Ingrese el teléfono del Local" required/>
                        </div>
                        <div class="form-group">
                            <label for="imagen_local">Imagen:</label>
                            <input type="file" name="imagen_local" placeholder="Imagen del Local" required/>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre_propietario">Nombre del propietario :</label>
                                <input type="text" name="nombre_propietario" placeholder="Nombre del Propietario" required="">
                            </div>
                            <div class="form-group">
                                <label for="apellido_propietario">Apellido del propietario :</label>
                                <input type="text" name="apellido_propietario" placeholder="Apellido del Propietario" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_propietario">Email del Propietario:</label>
                            <input type="email" name="email_propietario" placeholder="Ingrese el email del propietario" required/>
                        </div>
                        <div class="form-group">
                            <label for="contraseña">Contraseña:</label>
                            <input type="password" name="contraseña" placeholder="Ingrese una contraseña" required/>
                        </div>
                        <div class="form-group">
                            <label for="categoria1">Categoría de sus productos:</label>
                            <input type="text" name="categoria" placeholder="Ingrese la categoría de su producto (zapatos, ropa, viveres)" required/>
                        </div>

                        <div class="form-submit">
                            <input type="submit" id="submit" class="submit" name="registro_vendedor" value="Registrar">
                            <a href="index2.php"  id="" class="submit">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js_registro/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>