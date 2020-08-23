<?php
    $direccion="";
    $producto="";
    $idLocal="";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>DSAPP | Portal Comprador</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="./assets/css/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <!--Font awesome icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-image="./assets/img/sidebar-9.png" data-color="black">
            <div class="sidebar-wrapper">
                    <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

            Tip 2: you can also add an image using data-image tag
        -->
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="#" class="simple-text">
                            DSAPP
                        </a>
                    </div>
                    <ul class="nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="./maps.html">
                                <i class="nc-icon nc-pin-3"></i>
                                <p>Maps</p>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="#">
                                <i class="nc-icon nc-bell-55"></i>
                                <p>Notifications</p>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" class="appWhatsapp" href ="#"> 
                            <i class="nc-icon nc-chat-round"></i>                        
                            <p>WhatsApp</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <!-- Brand -->
                <h4 class="text-center text-info"><i class="fa fa-shopping-bag"></i>&nbsp;Realice sus compras de forma rápida y segura</h4>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <!--AQUI DEBE REGRESAR A LA PRINCIPAL-->
                        <a class="nav-link" href="./index.html" style="color:#17a2b8!important;"><i class="fa fa-arrow-left" style="color: #17a2b8!important;"></i>&nbsp;Regresar</a>
                    </li>
                </ul>
            </nav><br>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 px-4 pb-4">
                        <h4 class="text-center text-info">Ingrese los siguientes datos</h4>
                        <form action="" method="post" name="forma" id="forma">
                            <input type="hidden" name="id_local" value="<?php echo $codigo ?>">
                            <div class="form-group">
                                <label for="productos">Ingrese el producto que desea comprar</label>
                                <input type="text" class="form-control" name="productos" placeholder="Producto a comprar">
                            </div>
                            <div class="form-group">
                                <label for="direccion">Ingrese su dirección</label>
                                <input type="text" class="form-control" name="direccion" placeholder="Dirección del cliente">
                            </div>
                            <input type="submit" name="accion" value="Aceptar" class="btn btn-primary">
                            <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=+593962673246&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20el%20Producto%20.">Pedir</a>
                        
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 px-4 pb-4">
                        <h4 class="text-center text-info">Tiendas disponibles</h4>
                        <table id="tablaVendedores" class="table table-striped table-bordered table-condensed" style="width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th>Nombre del local</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST["accion"]) && ($_POST["accion"]=="Aceptar"))
                                        {   
                                            //$_SESSION['id_local'] = $row['id_local'];
                                            require 'config.php';
                                            $producto = $_POST['productos'];
                                            $direccion = $_POST['direccion'];
                                            $result = $conexion->query("SELECT * FROM tienda WHERE  categoria='$producto' AND direccion_local='$direccion'");
                                            if ($result->num_rows > 0) 
                                            {
                                                while($row = $result->fetch_assoc()) 
                                                {
                                                    $_SESSION['nombreLocal'] = $row['nombre_local'];
                                                    $_SESSION['idLocal'] = $row['id_local']; 
                                    ?>
                                    <tr>
                                        <!--<form action="" class="form-submit">-->
                                            <input type="hidden" name="nombreLocal" value="<?php echo $row ["nombre_local"]; ?>">
                                            <td><a href="./compras.php?tienda=<?php echo $row ["nombre_local"]; ?>" name="datoNombre"><?php echo $row ["nombre_local"];?></a></td>
                                            <td><?php echo $row ["direccion_local"];?></td>
                                            <td><?php echo $row ["telefono_local"];?></td>
                                        </form>
                                    </tr>
                                    <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                    ?>
                                    <tr>
                                        <td>No existen locales registrados</td>
                                    </tr>
                                    <?php
                                        } 
                                    ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#pablo"> Maps </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-palette"></i>
                                    <span class="d-lg-none">Dashboard</span>
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification">5</span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Notification 1</a>
                                    <a class="dropdown-item" href="#">Notification 2</a>
                                    <a class="dropdown-item" href="#">Notification 3</a>
                                    <a class="dropdown-item" href="#">Notification 4</a>
                                    <a class="dropdown-item" href="#">Another notification</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nc-icon nc-zoom-split"></i>
                                    <span class="d-lg-block">&nbsp;Search</span>
                                </a>
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </nav>
            <!--<div class="map-container">
                <div id="map"></div>
            </div>-->
            <!--INICIO DE MAPA-->
            <form action="" method="post" name="forma2" id="forma2">
            <style>
                            #map{position:absolute;left: 30px; top:600px; bottom:0px;height:500px ;width:1050px;}
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
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 px-4 pb-4">
                        <h4 class="text-center text-info">Ingrese los siguientes datos</h4>
                        
                            <input type="hidden" name="id_local" value="<?php echo $codigo ?>">
                            <div class="form-group">
                                <label for="productos">Ingrese el producto que desea comprar</label>
                                <input type="text" class="form-control" name="productos" placeholder="Producto a comprar">
                            </div>
                            <div class="form-grup">
                                <label for="direccion_local">Dirección del cliente:</label>
                                <input type="hidden" id="lat" name="lat">
                                <input type="hidden" id="lng" name="lng">
                            </div>
                            <input type="submit" name="accion2" value="Verificar" class="btn btn-primary">
                            <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=+593962673246&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20el%20Producto%20.">Pedir</a>
                        
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 px-4 pb-4">
                        <h4 class="text-center text-info">Tiendas disponibles</h4>
                        <table id="tablaVendedores" class="table table-striped table-bordered table-condensed" style="width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th>Nombre del local</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST["accion2"]) && ($_POST["accion2"]=="Verificar"))
                                        {  
                                            $lat = $_POST['lat'];
                                            $lng = $_POST['lng']; 
                                            //$_SESSION['id_local'] = $row['id_local'];
                                            require 'config.php';
                                            $producto = $_POST['productos'];
                                            //$direccion = $_POST['direccion'];

                                            $result = $conexion->query("SELECT *, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( lat ) ) ) ) AS distance 
                                                                        FROM tienda WHERE categoria = '$producto'
                                                                        HAVING distance < 25 ORDER BY distance LIMIT 0 , 20");
                                            //$result = $conexion->query("SELECT * FROM tienda WHERE  categoria='$producto' AND direccion_local='$direccion'");
                                            if ($result->num_rows > 0) 
                                            {
                                                while($row = $result->fetch_assoc()) 
                                                {
                                                    $_SESSION['nombreLocal'] = $row['nombre_local'];
                                                    $_SESSION['idLocal'] = $row['id_local']; 
                                    ?>
                                    <tr>
                                        <!--<form action="" class="form-submit">-->
                                            <input type="hidden" name="nombreLocal" value="<?php echo $row ["nombre_local"]; ?>">
                                            <td><a href="./compras.php?tienda=<?php echo $row ["nombre_local"]; ?>" name="datoNombre"><?php echo $row ["nombre_local"];?></a></td>
                                            <td><?php echo $row ["direccion_local"];?></td>
                                            <td><?php echo $row ["telefono_local"];?></td>
                                        </form>
                                    </tr>
                                    <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                    ?>
                                    <tr>
                                        <td>No existen locales registrados</td>
                                    </tr>
                                    <?php
                                        } 
                                    ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--FIN DE MAPA-->
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="./assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="./assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYj7YO-8Oe_VILXVZp_QpwRRaBMvLJhK4&callback=initMap"></script>
<!--  Chartist Plugin  -->
<script src="./assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="./assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="./assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="./assets/js/demo.js"></script>
<!--<script type="text/javascript">
    var marker;          //variable del marcador
    var coords = {};    //coordenadas obtenidas con la geolocalización
    
    //Funcion principal
    initMap = function () 
    {
        //usamos la API para geolocalizar el usuario
            navigator.geolocation.getCurrentPosition(
            function (position){
                coords =  {
                lng: position.coords.longitude,
                lat: position.coords.latitude
                };
                setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
            },function(error){console.log(error);});
    }
    //var idLocal = document.getElementsByClassName('idLocal')[0].value;

    function setMapa (coords)
    {   
        //Se crea una nueva instancia del objeto mapa
        var map = new google.maps.Map(document.getElementById('map'),
        {
            zoom: 13,
            center:new google.maps.LatLng(coords.lat,coords.lng),

        });

        //Creamos el marcador en el mapa con sus propiedades
        //para nuestro obetivo tenemos que poner el atributo draggable en true
        //position pondremos las mismas coordenas que obtuvimos en la geolocalización
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(coords.lat,coords.lng),
        });
        //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
        //cuando el usuario a soltado el marcador
        marker.addListener('click', toggleBounce);
        
        marker.addListener( 'dragend', function (event)
        {
            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
            document.getElementById("coords").value = this.getPosition().lat()+","+ this.getPosition().lng();
        });
    }
    
    //callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
    function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
</script>-->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYj7YO-8Oe_VILXVZp_QpwRRaBMvLJhK4&callback=initMap"></script>
</html>


</html>