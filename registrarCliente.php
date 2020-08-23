<?php
  if(isset($_POST["registro_cliente"]) && ($_POST["registro_cliente"]=="Registrar"))
  {
    include './services/serviciosVendedor.php';
    insertarCliente($_POST["nombre_cliente"],$_POST["apellido_cliente"],$_POST["cedula_cliente"],
    $_POST["telefono_cliente"],$_POST["email_cliente"],$_POST['contraña_cliente'],$_POST["direccion_cliente"]
    ,$_POST['lat'],$_POST['lng']);
    //header("location: chatCliente.php");AQUI DEBERIA IR A LA PAGINA PRINCIPAL DE INFORMACIÓN 
  }
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar Cliente</title>

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
                    <img src="images/signup-img2.jpg" alt="">
                </div>
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                        <h2>Registrar Nuevo Cliente</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre_cliente">Nombre :</label>
                                <input type="text" name="nombre_cliente" placeholder="Ingrese su nombre" required="">
                            </div>
                            <div class="form-group">
                                <label for="apellido_cliente">Apellido :</label>
                                <input type="text" name="apellido_cliente" placeholder="Ingrese su apellido" required="">
                            </div>
                        </div><br>
                        <div class="form-group">
                            <label for="cedula_cliente">Cédula:</label>
                            <input type="text" name="cedula_cliente" placeholder="Ingrese su cédula" required/>
                        </div><br>
                        <div class="form-group">
                            <label for="telefono_cliente">Teléfono :</label>
                            <input type="text" name="telefono_cliente" placeholder="Ingrese su teléfono" required/>
                        </div><br>
                        <div class="form-group">
                            <label for="email_cliente">E-mail:</label>
                            <input type="email" name="email_cliente" placeholder="Ingrese su correo electrónico" required/>
                        </div><br>
                        <div class="form-group">
                            <label for="contraña_cliente">Contraseña:</label>
                            <input type="password" name="contraña_cliente" placeholder="Ingrese una contraseña" required/>
                        </div><br>
                        <!--<div class="form-group">
                            <label for="direccion_cliente">Dirección:</label>
                            <input type="text" name="direccion_cliente" placeholder="Ingrese su dirección" required/>
                        </div><br>-->
                        <div class="form-grup">
                            <label for="direccion_local">Dirección del Cliente:</label>
                            <input type="text" name="direccion_cliente" placeholder="Ingrese la dirección del Local" required/>
                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lng" name="lng">
                        </div><br>

                        <style>
                            #map{position:absolute;left: 730px; top:770px; bottom:0px;height:250px ;width:660px;}
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
                        <br><br><br><br><br><br><br><br><br><br>
                        <div class="form-submit">
                            <input type="submit" id="submit" class="submit" name="registro_cliente" value="Registrar">
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