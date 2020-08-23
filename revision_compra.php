<?php
    session_start();
    require 'config.php';
    $nombre_local="";
    $id_local="";
    if(isset($_GET['tienda']))
    {
        $nombre_local= $_GET['tienda'];
        //require 'config.php';
        $result = $conexion->query("SELECT * FROM tienda WHERE nombre_local='$nombre_local'");
        if($result->num_rows>0)
        {
            $row1 = $result->fetch_assoc();
            $id_local = $row1["id_local"];
            
        }
        //session_start();
        //$_SESSION['nombreGlobal'] = $nombre_local;
        //$_SESSION['idGlobal'] = $id_local;    
    }

    /**if(isset($_POST['completarOrden']))
    {
        include './config.php';
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $metodoPago = $_POST['metodoPago'];
        $idLocal = $_POST['idLocal'];
        $gran_total = $_POST['gran_total'];
        $query = "SELECT nombre_cliente,apellido_cliente,cedula_cliente FROM clientes WHERE email_cliente='".$email."' and contraseña_cliente='".$contraseña."'";
        $result = mysqli_query($conexion,$query);
        $row=mysqli_fetch_assoc($result);
        if($row)
        {
          $nombre_cliente = $row['nombre_cliente'];
          $apellido_cliente = $row['apellido_cliente'];
          $cedula_cliente = $row['cedula_cliente'];
          $query = $conexion->prepare("INSERT INTO pedido (id_pedido,id_local,cedula_cliente,nombre_cliente,total_pedido,fecha_pedido,metodo_pago,estado)
            VALUES(?,?,?,?,?,NOW(),?)");
          $query->bind_param("issds",$idLocal,$cedula_cliente,$nombreCompleto,$gran_total,$metodoPago);
          $nombreCompleto = $nombre_cliente+" "+$apellido_cliente;
          $query->execute();
          $stmt->close();
          header("location: portalVendedor.php");
        }
    }**/
    $estado="activo";
    $grand_total=0;
    $itemsTotales = '';
    $items = array();

    $sql = "SELECT CONCAT(nombre_producto, '(',cantidad,')') AS cantidadItem, precio_total FROM carro_compra WHERE id_local='$id_local' AND estado='$estado'";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc())
    {
        $grand_total += $row['precio_total'];
        $items[]=$row['cantidadItem'];
    } 
    $itemsTotales = implode(", ", $items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSAPP | VERIFICAR COMPRA</title>

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
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
        <a class="navbar-brand" href="./compras.php"><i class="fa fa-shopping-bag"></i>&nbsp; <?php echo $nombre_local ?></a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./compras.php?tienda=<?php echo $nombre_local ?>">Productos</a>
                </li>
                <!--AQUI DEFINO EL CARRITO OJO EL ID=itemCarro-->
                <li class="nav-item">
                    <a class="nav-link" href="./carro_compra.php?tienda=<?php echo $nombre_local ?>"><i class="fa fa-shopping-cart"> <span  id="itemCarro" class="badge badge-danger"></span></i></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="revision_compra.php?tienda=<?php echo $nombre_local ?>">Compra</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./chatCliente.php">Salir</a>
                </li>
            </ul>
        </div>
    </nav><br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 pb-4" id="orden">
                <h4 class="text-center text-info">Completar datos para la compra</h4>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><strong> Producto(s):</strong>&nbsp;<?= $itemsTotales; ?></h6>
                    <h6 clasee="lead"><strong>Cargo delivery: </strong>Gratuito</h6>
                    <h5><strong>Total a pagar: </strong>&nbsp;<?= number_format($grand_total,2) ?></h5>
                </div>
                <form action="" method="post" id="ordenCompra">
                    <input type="hidden" name="idLocal" class="" id="idLocal" value="<?php echo $id_local ?>">
                    <input type="hidden" name="productos" value="<?= $itemsTotales ?>">
                    <input type="hidden" name="gran_total" value="<?= $grand_total ?>">
                    <div class="form-group">
                        <input type="text" name="correo" class="form-control" placeholder="Ingrese su Correo Electrónico">
                    </div>
                    <div class="form-group">
                        <input type="password" name="contraseña" class="form-control" placeholder="Ingrese su Contraseña">
                    </div>
                    <h6 class="text-center lead">Seleccione su método de pago</h6>
                    <div class="form-group">
                        <select name="metodoPago" class="form-control">
                            <option value="" selected disabled>Seleccione método de Pago</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="tarjeta">Tarjeta Débito/Crédito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="completarOrden" value="Completar Orden" class="btn btn-primary btn-block">
                    </div >
                </form>
                <div class="form-group">
                        <a href="registrarCliente.php"><input type="submit" name="submit" value="Es tu primera Orden?" class="btn btn-warning btn-block"></a>
                </div >
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        $("#ordenCompra").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'accion.php',
                method: 'post',
                data: $('form').serialize()+"&action=orden",
                success: function(response)
                {
                    $("#orden").html(response);
                }
            });
        });

        cargarCarrito();
        function cargarCarrito()
        {
            var idLocal = document.getElementsByClassName('idLocal')[0].value;
            $.ajax({
                url:'accion.php',
                method:'get',
                data:{cartItem:"cart-Item",idLocal:idLocal},
                success:function(response)
                {
                    $("#itemCarro").html(response);
                }
            });
        }
    });
</script>

</html>