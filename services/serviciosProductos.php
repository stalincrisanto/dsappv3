<?php
    function listarProductos()
    {
        //session_start();
        require './config.php';
        return $conexion->query("SELECT * FROM productos WHERE id_local = ".$_SESSION['id_local']);
    }

    function listarPedidos()
    {
        require './config.php';
        return $conexion->query("SELECT * FROM pedidos WHERE id_local = '".$_SESSION['id_local']."' AND estado='activo'");
    }
?>
