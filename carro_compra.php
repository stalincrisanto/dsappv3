<?php
    session_start();
    $nombre_local="";
    $id_local="";
    if(isset($_GET['tienda']))
    {
        $nombre_local= $_GET['tienda'];
        require 'config.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSAPP | COMPRAS</title>

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
                <li class="nav-item active">
                    <a class="nav-link active" href="./carro_compra.php?tienda=<?php echo $nombre_local ?>"><i class="fa fa-shopping-cart"> <span  id="itemCarro" class="badge badge-danger"></span></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./revision_compra.php?tienda=<?php echo $nombre_local ?>">Compra</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./map2.php">Salir</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
            <div style="display: <?php if(isset($_SESSION['showAlert'])) {echo $_SESSION ['showAlert'];} 
            else {echo 'none';} unset($_SESSION['showAlert']); ?> " class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>
                    <?php if(isset($_SESSION['message'])) {echo $_SESSION ['message'];}
                    unset($_SESSION['showAlert']);?>
                </strong>
            </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <td colspan="7"><h4 class="text-center text-info m-0">Productos en su Carro de Compras</h4></td>
                            </tr>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>IMAGEN</th>
                                <th>PRODUCTO</th>
                                <th>PRECIO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO TOTAL</th>
                                <th>
                                    <a href="accion.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Estás seguro de eliminar todas tus compras?');"><i class="fa fa-trash"></i>&nbsp; Limpiar Carrito</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require 'config.php';
                                $stmt = $conexion->prepare("SELECT * FROM carro_compra WHERE id_local='$id_local' AND estado='activo'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $total = 0;
                                while($row = $result->fetch_assoc())
                                {
                            ?>
                            <tr>
                                <input type="hidden" name="" class="idLocal" id="idLocal" value="<?php echo $id_local ?>">
                                <td><?= $row["id_producto"]; ?></td>
                                <input type="hidden" class="idProducto" value="<?= $row["id_producto"]; ?>">
                                <td><img src="<?= $row["imagen_producto"]; ?>" width="50"></td>
                                <td><?= $row["nombre_producto"] ?></td>
                                <td><i class="fa fa-usd">&nbsp;</i><?= number_format($row["precio_producto"],2); ?></td>
                                <input type="hidden" class="precioProducto" value="<?= $row["precio_producto"] ?>">
                                <td><input type="number" class="form-control operacionCantidad" value="<?= $row["cantidad"]; ?>" style="width:75px;"></td>
                                <td><i class="fa fa-usd"></i><?= number_format($row["precio_total"],2); ?></td>
                                <td>
                                    <a href="accion.php?remove=<?php echo $row["id_producto"]; ?>" class="text-danger lead" onclick="return confirm('Estás seguro de eliminar este producto?');"><i class="fa fa-trash"></i></a>
                                    <?php echo $row["id_producto"]; ?> 
                                </td>
                            </tr>
                            <?php 
                                $total += $row["precio_total"];
                            ?>
                            <?php } ?>
                            <tr>
                                <td colspan="3">
                                    <a href="./compras.php?tienda=<?php echo $nombre_local ?>" class="btn btn-success"><i class="fa fa-cart-plus"></i> Continuar Comprando</a>
                                </td>
                                <td colspan="2"><strong>Total de Compra</strong></td>
                                <td><i class="fa fa-usd"></i>&nbsp;<strong><?= number_format($total,2); ?></strong></td>
                                <td>
                                    <a href="revision_compra.php?tienda=<?php echo $nombre_local ?>" class="btn btn-info <?= ($total>1)?"":"disabled";?>"><i class="fa fa-credit-card"></i> Finalizar Compra</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        $(".operacionCantidad").on('change',function(){
            var $el = $(this).closest('tr');
            var idProducto = $el.find(".idProducto").val();
            var precioProducto = $el.find(".precioProducto").val();
            var cantidad = $el.find(".operacionCantidad").val();
            location.reload(true);
            $.ajax({
                url:'accion.php',
                method: 'post',
                cache: false,
                data: {cantidad:cantidad,idProducto:idProducto,precioProducto:precioProducto},
                success:function(response)
                {
                    console.log(response);
                }
            });
        });

        cargarCarrito();
         
        function cargarCarrito()
        {
            var idLocal = document.getElementsByClassName('idLocal')[0].value;
            //alert("VALORRRR"+idLocal);
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