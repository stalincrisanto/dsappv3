<!DOCTYPE html>
<html>
<?php
  $id_pedido="";
    session_start();
    if(isset($_SESSION['id_local'])==false)
    {
      echo($_SESSION['id_local']); 
      header("location:index2.php");
    }
    if(isset($_REQUEST['sesion'])&&($_REQUEST['sesion']=="cerrar"))
    {
      session_destroy();
      header("location:index2.php");
    }
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DSAPP | Vendedor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="jquery/jquery-3.5.1.min.js"></script>
  <script src="/sweet/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/@popperjs/core@2">
  <link rel="stylesheet" href="/sweet/sweetalert2.min.css">
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
<?php
  if(isset($_GET["completar"]))
  {
    /**$stmt = $conexion->prepare("UPDATE pedidos SET estado='completado' WHERE id_pedido=?");
    $stmt->bind_param("i", $idpedido);
    $idpedido = $_POST["idpedido"];
    $stmt->execute();
    $stmt->close();**/
    require 'config.php';
    $result = $conexion->query("SELECT * FROM pedidos WHERE id_pedido=".$_GET["completar"]);
    if($result->num_rows>0)
    {
      $row2 = $result->fetch_assoc();
      $id_pedido = $row2["id_pedido"];
    }
    $stmt = $conexion->prepare("UPDATE pedidos SET estado='completado' WHERE id_pedido=?");
    $stmt->bind_param("i", $codigoPedido);
    $codigoPedido = $id_pedido;
    $stmt->execute();
    $stmt->close();
    $stmt2 = $conexion->prepare("UPDATE carro_compra SET estado_vendedor='completado' WHERE id_local=?");
    $stmt2->bind_param("i", $_SESSION['id_local']);
    $stmt2->execute();
    $stmt2->close();
    $codigoPedido="";

    $stmt3 = $conexion->query("SELECT id_producto,cantidad FROM carro_compra WHERE disminuir is NULL");
    if($stmt3->num_rows>0)
    {
      while ($row = $stmt3->fetch_assoc())
      {
        $conexion->query("UPDATE productos SET existencia=existencia-'".$row['cantidad']."' WHERE id_producto='".$row['id_producto']."'");
        $conexion->query("UPDATE carro_compra SET disminuir='si' WHERE id_producto='".$row['id_producto']."' AND disminuir is NULL");
        //UPDATE productos SET existencia=existencia-1 WHERE id_producto = 3
      }
    }

  }
?>


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
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
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
        <!--<a href="#" class="btn btn-info btn-lg nav-link" data-widget="control-sidebar">
          <span class="glyphicon glyphicon-log-out"></span> Log out
        </a>-->
        <!--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <span class="glyphicon glyphicon-log-out"></span>
        </a>-->
        <a href="portalVendedor.php?sesion=cerrar" class="nav-link text-danger" role="button" title="Cerrar Sesión">
          <i class="fas fa-sign-out-alt"></i>
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
            <a href="catalogo.php" class="nav-link">
                <i class="nav-icon fa fa-shopping-bag" aria-hidden="true"></i>&nbsp;<p>Catálogo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ventas.php" class="nav-link  active">
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
</div>

<div class="content-wrapper">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark" style="text-align: center;">Pedidos de: <?php echo $_SESSION['nombre_local'] ?></h1>
      </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <div class="card-header" style="background-color: #6c757d;">
                <h3 style="color:white; text-align:center"><strong>Listado de Pedidos</strong></h3>
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
              
              <br><table class="table table-bordered table-hover table-condensed" id="tablaVentas">                  
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Cédula Cliente</th>
                    <th>Nombre</th>
                    <th>Total Pedido</th>
                    <th>Fecha</th>
                    <th>Método de Pago</th>
                    <th>Acción</th>
                  </tr> 
                </thead>
                <tbody>
                  <?php
                    require './services/serviciosProductos.php';
                    $result = listarPedidos();
                    if($result->num_rows>0)
                    {
                      while ($row = $result->fetch_assoc())
                      {
                  ?>
                    <tr>
                      <td> <?= $row["id_pedido"] ?> </td>
                      <td> <?= $row["cedula_cliente"] ?> </td>
                      <td> <?= $row["nombre_cliente"] ?> </td>
                      <td> <?= $row["total_pedido"] ?> </td>
                      <td> <?= $row["fecha_pedido"] ?> </td>
                      <td> <?= $row["metodo_pago"] ?> </td>
                      <td>
                        <div class="text-center">
                          <div class="btn-group">
                            <a href="ventas.php?completar=<?php echo $row ["id_pedido"];?>" type="button" class="btn btn-primary">Termir Venta</a>
                            <a href="detalle.php?tienda=<?php echo $_SESSION["id_local"]; ?>" type="button" class="btn btn-danger" >Detalles</a>               
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
