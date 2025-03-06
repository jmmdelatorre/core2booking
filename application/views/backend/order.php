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
    <?php $this->load->view('backend/include/base_css'); ?>
  </head>
  <body id="page-top">
    <?php $this->load->view('backend/include/base_nav'); ?>
    <div class="container-fluid">
    <h2 class=" text-gray-800">Booking List</h2>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
       
        <div class="card-title float-left">Booking List</div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
          <table class="table  table-condensed table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead >
                <tr>
                  <th>#</th>
                  <th>Code</th>
                  <th>Schedule Code</th>
                  <th>Terminal</th>
                  <th>Departure Date</th>
                  <th>Customer</th>
                  <th>Purchase Date</th>
                  <th>Ticket Qty.</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1;foreach ($order as $row) { ?>
                  <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['order_code']; ?></td>
                    <td><?= $row['schedule_id']; ?></td>
                    <td><?= $row['terminal_name']; ?></td>
                    <td><?= date('m/d/Y',strtotime($row['departure_date'])); ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= date('m/d/Y h:i A',strtotime($row['created_at']));?></td>
                    <?php $count_ticket = $this->db->query("SELECT * FROM tbl_transaction WHERE order_code LIKE '".$row['order_code']."'")->result_array(); ?>
                    <td><?= count($count_ticket); ?></td>
                    <td><?= strtoupper($row['payment_method']); ?></td>
                    <?php if ($row['payment_status'] ==='paid') { ?>
                          <td class="p-2 bg-success text-white"> Paid</td> 
                          <?php } elseif($row['payment_status'] === 'pending') { ?>
                            <td class="p-2 bg-warning text-white"> Pending</td> 
                        <?php } else { ?>
                          <td class="p-2 bg-warning text-white"> Pending</td> 
                          <?php } ?>
                    <td><a href="<?= base_url('backend/order/vieworder/'.$row['order_code']) ?>" class="btn btn btn-info btn-sm">Show passenger/s</a></td>
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

</div>

</div>
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<?php $this->load->view('backend/include/base_js'); ?>
</body>
</html>