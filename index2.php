<!DOCTYPE html>
<html lang="en">
<head>
	<title>DSAPP | Inicio de Sesión</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts_login/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts_login/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor_login/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css_login/util.css">
	<link rel="stylesheet" type="text/css" href="css_login/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<?php
				ob_start();
				if(isset($_REQUEST['login']))
				{
				  //echo("SI ESTOY INGRESADNO");
				  //echo($_REQUEST['email']);
				  //echo($_REQUEST['contraseña']);
				  session_start();
				  include './config.php';
				  $email = $_REQUEST['email']??'';
				  $codigo = $_REQUEST['codigo']??'';
				  $query = "SELECT id_local, email_propietario, nombre_local,imagen_local FROM tienda WHERE email_propietario='".$email."' and clave='".$codigo."'";
				  $buscarUsuario1 = "SELECT id_local, email_propietario, nombre_local FROM tienda  WHERE email_propietario ='$email'and clave='$codigo'"; 
				  $result = mysqli_query($conexion, $query);
				  /*$count = mysqli_num_rows($result);*/
				  /*$result = $mysqli->query($buscarUsuario);*/
				  if(!$result){
					var_dump(mysqli_error($conexion));
					exit;
				  }
				  $row=mysqli_fetch_assoc($result);
				  
				  
				  if($row)
				  {
					$_SESSION['id_local'] = $row['id_local'];
					$_SESSION['email_propietario'] = $row['email_propietario'];
					$_SESSION['nombre_local'] = $row['nombre_local'];
					$_SESSION['imagen_local'] = $row['imagen_local'];
					$mensaje="";
					header("location: portalVendedor.php");
				  }
				  else
				  {
					
				}
				
			  ?>
			  <div class="alert alert-danger" role="alert">
				Datos ingresados de forma incorrecta.
			  </div>
			  <?php } ?>
			  <?php
				if(isset($_REQUEST['loginCliente']))
				{
				  header("location: chatCliente.php");
				}
			  ?>
				<form class="login100-form validate-form" method="post">
					<div class="login100-form-avatar">
						<img src="images/avatar-01.jpg" alt="AVATAR">
					</div>
					<span class="login100-form-title p-t-20 p-b-45">
						Iniciar Sesión Vendedor
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="email" name="email" placeholder="Correo Electrónico">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="codigo" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button type="submit" class="login100-form-btn" name="login">
							Ingresar
						</button>
					</div>

					<div class="text-center w-full p-t-25 p-b-230">
						<a href="#" class="txt1">
							Olvidaste tu Contraseña ? 
						</a>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<a href="registrarVendedor.php" class="login100-form-btn">Eres Vendedor? Regístrate</a>
					</div>
					<div class="container-login100-form-btn p-t-10">
						<a href="registrarCliente.php" class="login100-form-btn">Eres Cliente? Regístrate</a>
					</div>
				</form>
			</div>
		</div>
	</div>
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>