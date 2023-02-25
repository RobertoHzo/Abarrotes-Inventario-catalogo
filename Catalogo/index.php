<?php
include_once '../global/ConfigServer.php';
include_once '../global/connection_DB.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Abarrotes La Guera - Reynosa</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>

	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="../index.php">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="index.php">Inicio</a>
								</li>
								<li><a href="Products.php">Productos</a></li>
								<li><a href="about.php">Sobre Nosotros</a></li>
								<li><a href="contact.php">Contacto</a></li>
								<li>
								</li>
							</ul>
						</nav>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->



	<!-- home page slider -->
	<div class="homepage-slider">
		<!-- single home slider -->
		<div class="single-homepage-slider homepage-bg-1">
			<div class="row">
				<div class="container ">
					<div class="col-lg-10 offset-lg-1 text-center">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">Amplia variedad de productos</p>
								<h1>Abarrotes La Guera</h1>
								<div class="hero-btns">
									<a href="Products.php" class="boxed-btn">Ver Productos</a>
									<a href="contact.php" class="bordered-btn">Visitanos</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- single home slider -->
		<div class="single-homepage-slider homepage-bg-2">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1 text-right">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">¡Deliciosos platillos!</p>
								<h1>Antojitos La Guera</h1>
								<div class="hero-btns">
									<a href="contact.php" class="boxed-btn">Visitanos</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end home page slider -->

	<!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">
						<h3><span class="orange-text">Productos</span> Nuevos</h3>
					</div>
				</div>
			</div>

			<div class="row product-lists">
				<!--phph  imagenes -->
				<?php
				$sql = "SELECT *  FROM products_tbl ORDER BY datemod_prod DESC LIMIT 3";
				$QueryProductos = $pdo->prepare($sql);
				$QueryProductos->execute();
				$ProductosLista = $QueryProductos->fetchAll(PDO::FETCH_ASSOC);
				?>
				<?php foreach ($ProductosLista as $producto) {
					$numCat = $producto['category_id']; ?>

					<div class="col-lg-4 col-md-6 text-center <?php echo $numCat ?>">
						<div class="single-product-item">
							<div class="product-image">
								<a><img src="../imagenes/img_productos/<?php echo $producto['photo']; ?>" alt="<?php echo $producto['name_prod'] ?>"></a>
							</div>
							<h4><?php echo $producto['name_prod']; ?></h4>
							<p class="product-price"><span>Por unidad</span> $ <?php echo $producto['saleprice']; ?> </p>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
	<?php include_once 'footer.php' ?>

	<?php include_once 'scripts.php' ?>

</body>

</html>