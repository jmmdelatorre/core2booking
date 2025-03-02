<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $title ?></title>
    <?php $this->load->view('backend/include/base_css'); ?>
  </head>
  <body id="page-top">
    <?php $this->load->view('backend/include/base_nav'); ?>
    <div class="container-fluid">
      <h2 class=" text-gray-800">Schedule Management</h2>
      <div class="card shadow mb-4">
        <div class="card-header card-accent-success py-3">
          <div class="card-title float-left">Available schedules</div>
          <a href="<?= base_url('schedule/add') ?>" class="btn btn-success float-right" >
          Add Schedule
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table  table-condensed table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Code</th>
                  <th>Terminal origin</th>
                  <th>Terminal desiination</th>
                  <th>Departure Date</th>
                  
                  <th>Departure Time</th>
                  <th>Arrival Date</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ; foreach ($schedule as $row ) { ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $row['schedule_id']; ?></td>
                  <td><?= strtoupper($row['terminal_origin']); ?></td>
                  <td><?= strtoupper($row['terminal_arrival']); ?></td>
                  <td><?= date('m/d/Y',strtotime($row['departure_date'])); ?></td>
                  <td><?= date('h:i A',strtotime($row['departure_time'])); ?></td>
                  <td><?= date('h:i A',strtotime($row['arrival_time'])); ?></td>
                  <!-- <td>Php<?= number_format((float)($row['price']),0,",","."); ?>,-</td> -->
                  <td>Php&nbsp;<?= number_format((float)($row['price']),0,",","."); ?></td>
                  <td><a href="<?= base_url('backend/jadwal/viewjadwal/'.$row['schedule_id']) ?>" class="btn btn-info">View</a></td>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('backend/include/base_footer'); ?>

<?php $this->load->view('backend/include/base_js'); ?>
</body>
</html>