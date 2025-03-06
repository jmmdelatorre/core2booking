<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?= $title ?></title>
	<!-- css -->
	<link rel="stylesheet"
		href="<?= base_url('assets/frontend/timepicker') ?>/css/bootstrap-material-datetimepicker.css" />
	<?php $this->load->view('backend/include/base_css'); ?>
</head>

<body id="page-top">
	<?php $this->load->view('backend/include/base_nav'); ?>
<div class="container-fluid">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
			</div>
			<div class="card-body">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
							<form class="user" method="post" action="<?= base_url('backend/admin/save') ?>">
								<?php if(isset($id_admin)) { ?>
									<input type="hidden" name="id_admin" value="<?= $id_admin; ?>">
								<?php } ?>
								<div class="form-group">
									<input type="text" class="form-control" id="exampleFirstName" name="name"
										value="<?= set_value('name', isset($name) ? $name : ''); ?>" placeholder="Full Name">
									<?= form_error('name') ? '<small class="text-danger pl-3">'.form_error('name').'</small>' : ''; ?>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Email Address" name="email"
										value="<?= set_value('email', isset($email) ? $email : ''); ?>">
									<?= form_error('email') ? '<small class="text-danger pl-3">'.form_error('email').'</small>' : ''; ?>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Username" name="username"
										value="<?= set_value('username', isset($username) ? $username : ''); ?>">
									<?= form_error('username') ? '<small class="text-danger pl-3">'.form_error('username').'</small>' : ''; ?>
								</div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="password"  class="form-control" name="password" placeholder="Password">
									</div>
									<div class="col-sm-6">
										<input type="password"   class="form-control" name="password2" placeholder="Repeat Password">
									</div>
								</div>
								<div class="form-group">
									<select class="form-control" name="level">
										<option value="2" <?= set_select('level', '2', (isset($level_admin) && $level_admin == '2')); ?>>Administrator</option>
										<option value="1" <?= set_select('level', '1', (isset($level_admin) && $level_admin == '1')); ?>>Superadmin</option>
									</select>
								</div>
								<?= form_error('password') ? '<small class="text-danger pl-3">'.form_error('password').'</small>' : ''; ?>
								<a href="<?= base_url('backend/admin')?>" class="btn btn-danger">Go Back</a>
								<button type="submit" class="btn btn-success float-right">
									<?= isset($id_admin) ? 'Update Account' : 'Add Account'; ?>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('backend/include/base_footer'); ?>
		<?php $this->load->view('backend/include/base_js'); ?>
</body>
</html>
