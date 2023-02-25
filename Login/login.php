<!DOCTYPE html>
<?php
require_once("../global/ConfigServer.php");
require_once("../global/connection_DB.php");
require("validacion.php");
?>
<html lang="es">

<head>
	<title>Iniciar Sesión - Administración</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title p-b-43">
						<b>La Guera Abarrotes<br>Panel de control</b>
					</span>

					<div class="wrap-input100 rs1 validate-input" data-validate="Se requiere el nombre de usuario">
						<input class="input100" type="text" name="name_user" id="name_user">
						<span class="label-input100">Usuario</span>
					</div>
					<div class="wrap-input100 rs2 validate-input" data-validate="Se requiere la contraseña">
						<input class="input100" type="password" name="pass_user" id="pass_user">
						<span class="label-input100">Contraseña</span>
					</div>
					<!-- boton de login -->
					<div class="container-login100-form-btn">
						<button type="submit" name="login" class="login100-form-btn">
							Entrar
						</button>
					</div>
					<br>
					<br>
					<div class="text-center w-full p-t-23">
						<?php
						// para mostrar el mensaje de error
						if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
							echo "<div style='color: #ffc800; background-color: #1a100280;'>
								Usuario o contraseña invalido, por favor vuelva a intertarlo </div>";
						}?>
					</div>
					<br>
					<div class="text-center w-full p-t-23">
						<a href="../Catalogo/index.php" class="txt1">
							<b>< Volver a la página</b>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<script src="js/main.js"></script>
</body>

</html>