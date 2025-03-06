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
		<title>Booking</title>
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
		<!--CSS-->
		<?php $this->load->view('frontend/include/css'); ?>
	</head>
	<body>
		<?php $this->load->view('frontend/include/base_nav'); ?>
		
		<section class="banner-area relative section-gap relative" id="home">
		<div class="container">
				<div class="row fullscreen d-flex align-items-center justify-content-end">
						<div class="col-lg-12">
						<div class="card mb-5">
							<div class="card-header">
								<i class="fas fa-list"></i> Available List
							</div>
							<div class="card-body">
								<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead >
										<tr>
											<th scope="col">Schedule Code</th>
											<th>Terminal</th>
											<th scope="col">Date</th>
                                            <th scope="col">Time</th>
											<th>Price</th>
											<th scope="col">Action</th>
										</tr>
									</thead>
									<tbody>
    <?php if (!empty($schedule) && count($schedule) > 0) { ?>
        <?php foreach ($schedule as $sched) { ?>
            <tr>
                <td><?php echo $sched['schedule_id']; ?></td>
                <td><?php echo $sched['terminal_name']; ?></td>
                <td><?php echo date('m/d/Y', strtotime($sched['departure_date'])); ?></td>
                <td><?php echo date('h:i A', strtotime($sched['departure_time'])); ?></td>
                <td>Php <?php echo number_format((float)($sched['price']), 0, ",", "."); ?></td>
                <td>
                    <a href="<?php echo base_url('ticket/book/' . $sched['schedule_id'] . '/' . $numpass); ?>" class="btn btn-sm btn-outline-success">
                        Book now
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="6" class="text-center text-danger">
                No available schedules found. Please try again later.
            </td>
        </tr>
    <?php } ?>
</tbody>
								</table>
								</div>
								<a href="<?php echo base_url('home') ?>" class="btn btn-danger pull-left">Go Back </a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				
				<?php $this->load->view('frontend/include/base_js'); ?>
			</body>
		</html>