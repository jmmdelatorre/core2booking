<!DOCTYPE html>
<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/elements/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Log on to codeastro.com for more projects -->
		<!-- Site Title -->
		<title>Get Tickets</title>
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
		<!--CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/datepicker/dcalendar.picker.css">
		<?php $this->load->view('frontend/include/css'); ?>
	</head>
	<body>
		<!-- navbar -->
		<?php $this->load->view('frontend/include/base_nav'); ?>
		<section class="banner-area relative section-gap relative" id="home">
		<div class="container">
				<div class="row fullscreen d-flex align-items-center justify-content-end">
					<div class="col-lg-6">
						<!-- Default Card Example -->
						<div class="card wobble">
					  <div class="card-header">
					   <i class="fas fa-ticket"></i> Check My Tickets
					  </div>
					  <div class="card-body">
					
					    <form action="<?php echo base_url() ?>TicketController/retrieve_ticket" method="post">
									<div class="form-group">
										<label for="exampleInputEmail1">Enter your Booking code</label>
										<input type="text" id="" class="form-control" id="" name="order_code" placeholder="Order Code" required="">
									</div>
									<button type="submit" class="btn btn-success pull-right">Search </button>
								</form>
					  </div>
					</div>
					</div>
			</section>
			<!-- End banner Area -->
			<!-- Log on to codeastro.com for more projects -->
			<!-- start footer Area -->
			<?php $this->load->view('frontend/include/base_footer'); ?>
			<!-- js -->
			<?php $this->load->view('frontend/include/base_js'); ?>
		</body>
	</html>