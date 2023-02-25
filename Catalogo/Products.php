<?php
include '../global/ConfigServer.php';
include '../global/connection_DB.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- title -->
	<title>Productos</title>

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

	<style>
		.btn-group-lg>.btn, .btn-lg {
		padding: .5rem 1rem;
		font-size: 2rem;
		line-height: 1.5;
		border-radius: 1.3rem;
		box-shadow: 0px 0px 20px rgb(225 83 97 / 50%);
		
	}
	.btn-danger {
    color: #fff;
    background-color: #af0202;
    border-color: #af0202;
}
	</style>

</head>
<body>	
	<!--PreLoader-->
    <!-- <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div> -->
    <!--PreLoader Ends-->	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.php">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li ><a href="index.php">Inicio</a>
								</li>
								<li class="current-list-item"><a href="Products.php">Productos</a>									
								</li>
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
		
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg-product">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p><i>Nuestros</i></p>
						<h1>Productos</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	<!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">			
			<!--Categorias-->
			<div class="row">
                <div class="col-md-12">
                    <div class="dropdown product-filters" style="text-align: center;">
					<button class="btn btn-danger btn-lg dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" 
					aria-haspopup="true" aria-expanded="false" data-offset="auto">Categorias
					</button> 						
						<ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="dropdownMenuButton">
							<li class="active" data-filter="*" data-value="Todos">Todos</li>
							<!-- <li data-filter=".bebidas">Bebidas</li>-->							
							<?php
							$sql1="SELECT * FROM categories_tbl";
							$QueryCat = $pdo->prepare($sql1);
							$QueryCat->execute();
							$CatLista1=$QueryCat->fetchAll(PDO::FETCH_ASSOC);
							?>
							<?php foreach($CatLista1 as $cat1) { ?>
								<li data-filter=".<?php echo $cat1['category_id'] ?>" data-value="<?php echo $cat1['name_cat'] ?><"><?php echo $cat1['name_cat'] ?></li>
							<?php } ?>
						</ul>
                    </div> 
                </div>
            </div>
					<!--/Categorias-->
				
            
			<div class="row product-lists"">
				<!--phph  imagenes -->
				<?php
				$sql="SELECT * FROM products_tbl";
				$QueryProductos = $pdo->prepare($sql);
				$QueryProductos->execute();
				$ProductosLista=$QueryProductos->fetchAll(PDO::FETCH_ASSOC);
				?>
				<?php foreach($ProductosLista as $producto) {
					$numCat= $producto['category_id']; ?>
															
						<div class="col-xs-6 col-sm-6 col-lg-4 col-md-6 text-center  <?php echo $numCat ?>"> 
							<div class="single-product-item">
								<div class="product-image">
									<a ><img src="../imagenes/img_productos/<?php echo $producto['photo']; ?>" alt="<?php echo $producto['name_prod'] ?>"></a>
								</div>
								<h4><?php echo $producto['name_prod']; ?></h4>
								<p class="product-price"><span>Por unidad</span> $ <?php echo $producto['saleprice']; ?> </p>
							</div>
						</div>																			
				<?php } ?>
				<!-- /php imagenes -->							
			</div> 
		</div>			
		
	</div>
	<!-- end products -->
	<?php include 'footer.php' ?>

	
	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>
	<script>
		$(".dropdown-menu li ").click(function(){
		$(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
		$(this).parents(".dropdown").find('.btn').val($(this).data('value'));
		});
	
	</script>

	

</body>
</html>