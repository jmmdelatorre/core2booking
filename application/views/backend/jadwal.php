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
        <div class="card-header py-3">
          <a href="<?= base_url('backend/jadwal/tambahjadwal') ?>" class="btn btn-success pull-right" >
          Add Schedule
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Code</th>
                  <th>Origin</th>
                  <th>Destination</th>
                  <th>Departure</th>
                  <th>Arrival</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ; foreach ($jadwal as $row ) { ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $row['kd_jadwal']; ?></td>
                  <td><?= strtoupper($row['kota_tujuan']); ?></td>
                  <td><?= strtoupper($row['wilayah_jadwal']); ?></td>
                  <td><?= date('H:i',strtotime($row['jam_berangkat_jadwal'])); ?></td>
                  <td><?= date('H:i',strtotime($row['jam_tiba_jadwal'])); ?></td>
                  <!-- <td>$<?= number_format((float)($row['harga_jadwal']),0,",","."); ?>,-</td> -->
                  <td>$<?= number_format((float)($row['harga_jadwal']),0,",","."); ?></td>
                  <td><a href="<?= base_url('backend/jadwal/viewjadwal/'.$row['kd_jadwal']) ?>" class="btn btn-info">View</a></td>
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