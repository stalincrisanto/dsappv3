<?php
    session_start();
    require("./config.php");
    $estado="activo";
    $estado_vendedor="activo";

    if(isset($_POST["idProducto"]))
    {
        //$estado="activo";
        $idLocal = $_POST["idLocal"];
        $idProducto = $_POST["idProducto"];
        $nombreProducto = $_POST["nombreProducto"];
        $precioProducto = $_POST["precioProducto"];
        $imagenProducto = $_POST["imagenProducto"];
        $cantidad = 1;
        
        $stmt = $conexion->prepare("SELECT id_producto FROM carro_compra WHERE id_producto=? AND id_local=? AND estado='activo'");
        $stmt->bind_param("ii",$idProducto,$idLocal);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = $res->fetch_assoc();
        $code = $r["id_producto"];
        
        if(!$code)
        {
            $query = $conexion->prepare("INSERT INTO carro_compra (id_producto,id_local,nombre_producto,precio_producto,imagen_producto,cantidad,precio_total,estado,estado_vendedor)
            VALUES(?,?,?,?,?,?,?,?,?)");
            $query->bind_param("iisdsidss",$idProducto,$idLocal,$nombreProducto,$precioProducto,$imagenProducto,$cantidad,$precioProducto,$estado,$estado_vendedor);
            $query->execute();
            echo('<div class="alert alert-success alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Producto añadido al carrito</strong> 
                  </div>');
        }
        else
        {
            echo('<div class="alert alert-danger alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>El producto ya ha sido añadido previamente</strong> 
                  </div>');

        }
    }

    if(isset($_GET["cartItem"]) && isset($_GET["cartItem"])=="cart-Item")
    {
        //$estado = "activo";
        $idLocal = $_GET['idLocal'];
        $stmt = $conexion->prepare("SELECT * FROM carro_compra WHERE id_local='$idLocal' AND estado='$estado'");
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows();
        echo $rows;
    }

    if(isset($_GET["remove"]))
    {
        echo("VALOR!!".$_GET["remove"]);
        $id = $_GET["remove"];
        $stmt = $conexion->prepare("DELETE FROM carro_compra WHERE id_producto=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Producto eliminado del carro de compras';
        header('location:carro_compra.php');
    }

    if(isset($_GET["clear"]))
    {
        $stmt = $conexion->prepare("DELETE FROM carro_compra");
        $stmt->execute();
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Sin productos en el carro de compras';
        header('location:carro_compra.php');
    }

    if(isset($_POST["cantidad"]))
    {
        $cantidad = $_POST["cantidad"];
        $idProducto = $_POST["idProducto"];
        $precioProducto = $_POST["precioProducto"];

        $precioTotal = $cantidad*$precioProducto;
        $stmt = $conexion->prepare("UPDATE carro_compra SET cantidad=?, precio_total=? WHERE id_producto=?");
        $stmt->bind_param("idi",$cantidad,$precioTotal,$idProducto);
        $stmt->execute();
    }

    if(isset($_POST['action'])&& isset($_POST['action'])=='orden')
    {
        include './config.php';
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $metodoPago = $_POST['metodoPago'];
        $idLocal = $_POST['idLocal'];
        $gran_total = $_POST['gran_total'];
        $query = "SELECT nombre_cliente,apellido_cliente,cedula_cliente FROM clientes WHERE email_cliente='".$correo."' AND contraseña_cliente='".$contraseña."'";
        $result = mysqli_query($conexion,$query);
        $row=mysqli_fetch_assoc($result);
        if($row)
        {
            //$estado="activo";
            $nombre_cliente = $row['nombre_cliente'];
            $apellido_cliente = $row['apellido_cliente'];
            $cedula_cliente = $row['cedula_cliente'];
            $stmt = $conexion->prepare("INSERT INTO pedidos (id_local,cedula_cliente,nombre_cliente,total_pedido,fecha_pedido,metodo_pago,estado)
                VALUES(?,?,?,?,NOW(),?,?)");
            $stmt->bind_param("issdss",$idLocal,$cedula_cliente,$nombreCompleto,$gran_total,$metodoPago,$estado);
            $nombreCompleto = $nombre_cliente." ".$apellido_cliente;
            $stmt->execute();
            $stmt->close();
            $productos = $_POST['productos'];
            $metodoPago = $_POST['metodoPago'];
            $data = '';
            $data.='<div class="text-center">
                    <h1 class="display-4 mt-2 text-danger">Gracias por utilizar DSAPP</h1>
                    <h2 class="text-success">Su orden ha sido completada y enviada al Vendedor</h2>
                    <h4 class="bg-danger text-light rounded p-2">Artículos Comprados: '.$productos.' </h4>
                    <a href="index.html"><input type="submit" name="submit" value="Aceptar" class="btn btn-success btn-block"></a>                    
                    </div>';
            echo $data;
            
            /**$stmt3 = $conexion->prepare("SELECT id_pedido FROM pedidos WHERE id_local = '$idLocal' AND estado='activo'");
            $stmt3->execute();
            $idPedido = $stmt3->get_result();

            $query = "SELECT * FROM carro_compra WHERE id_local='".$idLocal."' AND estado='activo'";
            $result = mysqli_query($conexion,$query);
            $row=mysqli_fetch_assoc($result);
            while($row)
            {
                $id_producto = $row['id_producto'];
                $nombre_producto = $row['nombre_producto'];
                $precio = $row['precio_producto'];
                $cantidad = $row['cantidad'];
                $precio_total=$row['precio_total'];
                $stmt4 = $conexion->prepare("INSERT INTO detalle_pedido (id_pedido, id_local, id_producto, nombre_producto, cantidad
                ,precio_unitario
                ,precio_total
                )
                VALUES(?,?,?,?,?,?,?)");
                $stmt4->bind_param("iiisidd",$idPedido,$idLocal,$id_producto,$nombre_producto,$cantidad,$precio,$precio_total);
                $stmt4->execute();
                $stmt4->close();
            }**/

            $stmt2 = $conexion->prepare("UPDATE carro_compra SET estado='completado' WHERE id_local=? AND estado='activo'");
            $stmt2->bind_param("i", $idLocal);
            $stmt2->execute();
            $stmt2->close();
          //header("location: portalVendedor.php");
        }
        else
        {
            $data2 = '';
            $data2.='<div class="text-center">
                    <h1 class="display-4 mt-2 text-danger">Datos Inválidos</h1>
                    <h2 class="text-success">Ingrese sus datos correctos</h2>
                </div>';
            echo $data2;
        }

        /**$idLocal = $_POST['idLocal'];
        $nombre=$_POST['nombre'];
        $apellido = $_POST['apellidos'];
        $apellido = $_POST['apellidos'];
        $cedula = $_POST['cedula'];
        $telefono = $_POST['telefono'];
        $mail = $_POST['mail'];
        $direccion = $_POST['direccion'];
        $granTotal = $_POST['gran_total'];**/
        //$productos = $_POST['productos'];
        //$metodoPago = $_POST['metodoPago'];

        //$data = '';

        //$stmt = $conexion->prepare("INSERT INTO orders(campo1, campo2, campo3) VALUES(?,?,?)");
        //$stmt->bind_param("ssss",$nombre,$apellido,$cedula);
        //$stmt->execute();
        /**$data.='<div class="text-center">
                    <h1 class="display-4 mt-2 text-danger">Gracias por utilizar DSAPP</h1>
                    <h2 class="text-success">Su orden ha sido completada y enviada al Vendedor</h2>
                    <h4 class="bg-danger text-light rounded p-2">Artículos Comprados: '.$productos.' </h4>
                </div>';
        echo $data;**/
    }
?>
