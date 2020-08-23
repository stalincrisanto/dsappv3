<?php
    $direccion="";
    $producto="";
    $idLocal="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSAPP | Portal Comprador</title>

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
                <!--<form action="" method="post" id="ordenCompra">
                    <input type="hidden" name="productos" value="<?= $itemsTotales ?>">
                    <input type="hidden" name="gran_total" value="<?= $grand_total ?>">
                    <div class="form-group">
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="apellidos" class="form-control" placeholder="Ingrese sus apellidos" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="cedula" class="form-control" placeholder="Ingrese su cédula" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="telefono" class="form-control" placeholder="Ingrese su teléfono" required>
                    </div>
                    <div class="form-group">
                        <input type="mail" name="mail" class="form-control" placeholder="Ingrese su correo" required>
                    </div>
                    <div class="form-group">
                        <textarea name="direccion" class="form-control" rows="3" cols="10" placeholder="Ingrese su dirección"></textarea>
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
                        <input type="submit" name="submit" value="Completar Orden" class="btn btn-danger btn-block">
                    </div >
                </form>-->
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
                   
                <!--</form>-->
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
</body>

<!--<script type="text/javascript">
    $(document).ready(function(){
        $(".botonFormulario").click(function(e){
            e.preventDefault();
            var $form = $(this).closest(".form-submit");
            var nombreLocal = $form.find(".nombreLocal").val();
            $.ajax({
                url:"compras.php",
                method:"post",
                data:{nombreLocal:nombreLocal},
                success:function(response)
                {
                    //console.log("OK");
                }
            });
        });
    });
</script>-->

</html>