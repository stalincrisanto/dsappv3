<?php
    function listarProductos()
    {
        require './conexion.php';
        return $conexion->query("SELECT * FROM productos");
    }
?>
