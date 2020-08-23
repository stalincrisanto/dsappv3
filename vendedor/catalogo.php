<!DOCTYPE html>
<html>
<?php
    session_start();
    $codigo="";
    $nombre = "";
    $precio = "";
    $descripcion = "";
    $existencia = "";
    $imagen = "";
    $accion = "Agregar";
    if(isset($_POST["accion"]) && ($_POST["accion"]=="Agregar"))
    {
        require 'conexion.php';
        /**AQUI GUARDO EN LAS VARIABLES CON EL POST, PEEERO DEL POST TIENE QUE SER LO QUE MANDO DEL FORMULARIO**/
        $stmt = $conexion->prepare("INSERT INTO productos (nombre_producto, precio_producto, descripcion_producto, existencia, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsis", $nombre, $precio, $descripcion, $existencia, $imagen);
        $nombre = $_POST["nombreProducto"];
        $precio = $_POST["precioProducto"];
        $descripcion = $_POST["descripcionProducto"];
        $existencia = $_POST["existenciaProducto"];
        $imagen = $_POST["imagenProducto"];
        $stmt->execute();
        $stmt->close();
        //$codigo="";
        $nombre = "";
        $precio = "";
        $descripcion = "";
        $existencia = "";
        $imagen = "";
    }

    else if(isset($_POST["accion"]) && ($_POST["accion"]=="Modificar"))
    {
        require 'conexion.php';
        $stmt = $conexion->prepare("UPDATE productos set nombre_producto=?,precio_producto=?,descripcion_producto=?,existencia=?,imagen=? WHERE id_producto=?");
        $stmt->bind_param("sdsisi", $nombre, $precio, $descripcion, $existencia, $imagen,$codigo);
        $nombre = $_POST["nombreProducto"];
        $precio = $_POST["precioProducto"];
        $descripcion = $_POST["descripcionProducto"];
        $existencia = $_POST["existenciaProducto"];
        $imagen = $_POST["imagenProducto"];
        $codigo = $_POST["codigoProducto"];
        $stmt->execute();
        $stmt->close();
        $nombre = "";
        $precio = "";
        $descripcion = "";
        $existencia = "";
        $imagen = "";
    }

    else if(isset($_GET["update"]))
    {
      require 'conexion.php';
        $result = $conexion->query("SELECT * FROM productos WHERE id_producto=".$_GET["update"]);
        if($result->num_rows>0)
        {
            $row1 = $result->fetch_assoc();
            $codigo = $row1["id_producto"];
            $nombre = $row1 ["nombre_producto"];
            $precio = $row1["precio_producto"];
            $descripcion = $row1["descripcion_producto"];
            $existencia = $row1["existencia"];
            $imagen = $row1["imagen"];
            $accion = "Modificar";
        }
    }

    else if(isset($_GET["delete"]))
    {
      require 'conexion.php';
        $result = $conexion->query("SELECT * FROM productos WHERE id_producto=".$_GET["delete"]);
        if($result->num_rows>0)
        {
            $row2 = $result->fetch_assoc();
            $codigoEliminar = $row2["id_producto"];
        }
        $stmt = $conexion->prepare("DELETE FROM productos WHERE id_producto=?");
        $stmt->bind_param("i", $codigo);
        $codigo = $codigoEliminar;
        $stmt->execute();
        $stmt->close();
        $codigo="";
    }

    /*else if(isset($_POST["eliminarCodigo"]))
    {
        $stmt = $conexion->prepare("DELETE FROM productos WHERE codigo=?");
        $stmt->bind_param("i", $codigo);
        $codigo = $_POST["eliminarCodigo"];
        $stmt->execute();
        $stmt->close();
        $codigo="";
    }*/
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DSAPP | Vendedor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="jquery/jquery-3.5.1.min.js"></script>
  <script src="js/funciones.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<!-- 
    RTL version
-->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
        </a>
        
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Menú lateral izquierdo -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!--AQUI VA LA FOTO DEL LOGO DE LA TIENDA-->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Vendedor | DSAPP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nombre_local']; ?></a>
        </div>
    </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="./portalVendedor.php" class="nav-link">
                <i class="nav-icon fas fa-chart-bar" aria-hidden="true"></i>&nbsp;<p>Portal</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="catalogo.php" class="nav-link active">
                <i class="nav-icon fa fa-shopping-bag" aria-hidden="true"></i>&nbsp;<p>Catálogo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ventas.php" class="nav-link">
                <i class="nav-icon fa fa-table" aria-hidden="true"></i>&nbsp;<p>Ventas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clientes.php" class="nav-link">
                <i class="nav-icon fa fa-user" aria-hidden="true"></i></i>&nbsp;<p>Clientes</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


<form action="./catalogo.php" name="forma" method="post" id="forma">
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <div class="card-header" style="background-color: #6c757d;">
                <h3 style="color:white; text-align:center"><strong>Listado de Productos</strong></h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <caption>
                  <a href="#editar" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Nuevo Producto</a>
                <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modalAñadir">
                  <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Producto
                </button>-->
              </caption><br>
              <br><table class="table table-bordered table-hover table-condensed" id="tablaProductos">                  
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Existencia</th>
                    <th>Imagen</th>
                  </tr> 
                </thead>
                <tbody>
                  <?php
                    require './services/serviciosProductos.php';
                    $result = listarProductos();
                    if($result->num_rows>0)
                    {
                      while ($row = $result->fetch_assoc())
                      {
                  ?>
                    <tr>
                      <td> <?= $row["id_producto"] ?> </td>
                      <td> <?= $row["nombre_producto"] ?> </td>
                      <td> <?= $row["precio_producto"] ?> </td>
                      <td> <?= $row["descripcion_producto"] ?> </td>
                      <td> <?= $row["existencia"] ?> </td>
                      <td><img src="<?= $row["imagen"]; ?>" width="50"></td>
                      <td>
                        <div class="text-center">
                          <div class="btn-group">
                            <a href="catalogo.php?update=<?php echo $row ["id_producto"];?>#editar" type="button" class="btn btn-primary">Editar</a>
                            <a href="catalogo.php?delete=<?php echo $row ["id_producto"];?>" type="button" class="btn btn-danger">Eliminar</a>               
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php
                      }
                    }
                    else
                    {
                      echo"No hay datos";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="content">
    <div class="row">  
      <div class="col-12">
        <div class="card">
          <div class="card-body"  style="background-color: #6c757d;">
            <h2 class="text-center text-light">Añadir Nuevo Producto</h2>
          </div>
        </div>
        <div>
          <div class="card-body">
            <!--<form action="index.php" name="forma" method="post" id="forma">-->
              <input type="hidden" name="codigoProducto" value="<?php echo $codigo ?>">
                <div class="form-group row" id="editar">
                  <label for="nombreProducto" id="lblNombreProducto" class="col-sm-3 col-form-label">Nombre del Producto</label>
                  <div class="col-sm-7">
                      <input type="text" name="nombreProducto" value="<?php echo $nombre ?>" require class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="precioProducto" id="lblPrecioProducto" class="col-sm-3 col-form-label">Precio del Producto</label>
                  <div class="col-sm-7">
                    <input type="text" name="precioProducto" value="<?php echo $precio?>" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="descripcionProducto" id="lbldescripcionProducto" class="col-sm-3 col-form-label">Descripcion Producto</label></td><br>
                    <div class="col-sm-7">
                      <input type="text" name="descripcionProducto" value="<?php echo $descripcion?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                  <label for="existenciaProducto" id="lblexistenciaProducto" class="col-sm-3 col-form-label">Existencia del Producto</label></td><br>
                    <div class="col-sm-7">
                      <input type="text" name="existenciaProducto" value="<?php echo $existencia?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                  <label for="imagenProducto" id="lblimagenProducto" class="col-sm-3 col-form-label">Imagen del Producto</label></td><br>
                    <div class="col-sm-7">
                      <input type="text" name="imagenProducto" value="<?php echo $imagen?>" class="form-control">
                    </div>
                </div>
                  <input type="submit" name="accion" value="<?php echo $accion ?>" class="btn btn-primary">
              </form>
          </div>
        </div>
      </div>
    </div> 
  </section>
</div> 
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
