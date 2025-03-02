<!DOCTYPE html>
<html lang="zxx" class="no-js">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="img/elements/fav.png">
		<meta name="author" content="colorlib">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta charset="UTF-8">
		<title>core2</title>
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
		<?php $this->load->view('frontend/include/css.php '); ?>
		<?php $this->load->view('frontend/include/scripts.php'); ?>
	</head>
	<body>
		<?php $this->load->view('frontend/include/base_nav'); ?>
		<section class="banner-area relative section-gap relative" id="home">
			<div class="container">
				<div class="row fullscreen d-flex align-items-center justify-content-end">
					<div class="banner-content col-lg-7 col-md-12">
						<?php $this->load->view('frontend/ticket_create.php')?>
					</div>
				</div>
			</div>
		</section>
		
	</body>
</html>