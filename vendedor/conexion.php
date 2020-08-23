<?php
    //$db="vendedor";
    $conexion = mysqli_connect("localhost","root","","vendedor");
    if(!$conexion)
    {
        echo("FALLO LA CONEXION");
    }
    /**function nombre()
    {
        return "vendedor";
    }**/
?>
