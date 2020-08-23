<?php
    $conexion = new mysqli("localhost","root","","tienda_online");
    if($conexion->connect_error)
    {
        die("Conexión Fallida".$conexion->connect_error);
    }
?>