<?php 
    function insertarVendedor($nombrel, $direccionl,$telefonol,$imagenl,
    $nombrep,$apellidop,$emailp,$contraseña,$categoria1,$lat,$lng)
    {
        include "./config.php";
        //$conexion = getConex();
        $stmt = $conexion->prepare("INSERT INTO tienda (nombre_local,direccion_local,telefono_local,imagen_local,
        nombre_propietario,apellido_propietario,email_propietario,
        clave, categoria,lat,lng) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssdd',$nombrel, $direccionl,$telefonol,$imagenl,
        $nombrep,$apellidop,$emailp,$contraseña,$categoria1,$lat,$lng);
        $stmt->execute();
        $stmt->close();
        $conexion->close();
    }
    function insertarCliente($nombrec, $apellidoc,$cedulac,$telefonoc,
    $emailc,$contraseñac,$direccionc,$lat,$lng)
    {
        include "./config.php";
        //$conexion = getConex();
        $stmt = $conexion->prepare("INSERT INTO clientes (nombre_cliente,apellido_cliente,cedula_cliente,
        telefono_cliente,email_cliente,contraseña_cliente,direccion,lat,lng) VALUES(?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssdd',$nombrec, $apellidoc,$cedulac,$telefonoc,
        $emailc,$contraseñac,$direccionc,$lat,$lng);
        $stmt->execute();
        $stmt->close();
        $conexion->close();
    }
?>