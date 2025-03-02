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
      <h2 class=" text-gray-800">Bus Management</h2>
        
      <div class="card shadow mb-4">
        <div class="card-header card-accent-success py-3">
          <div class="card-title float-left">List of Bus</div>
          <button type="button" class="btn btn-outline-success float-right" data-toggle="modal" data-target="#modalbus">
          <i class="fas fa-plus"></i>Add 
          </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table  table-condensed table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead >
                <tr>
                  <th>#</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Plate#</th>
                  <th>Capacity</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ; foreach ($bus as $row ) { ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= strtoupper($row['bus_id']); ?></td>
                  <td><?= strtoupper($row['bus_name']); ?></td>
                  <td><?= strtoupper($row['bus_plate']); ?></td>
                  <td><?= $row['bus_capacity'] ?></td>
                  <?php if ($row['bus_status'] == '1') { ?>
                    <td class="text-success"> Active</td> 
                    <?php } else { ?>
                    <td class="text-danger">InActive</td>
                  <?php } ?>
                  <td align="center"><a href="<?= base_url('backend/BusController/viewbus/'.$row['bus_id'])?>" class="btn btn-sm btn-info"><i class="fas fa-search"></i>&nbsp;View</a></a>
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

<div class="modal fade modal-vertical-centered" id="modalbus" tabindex="-1" role="dialog" aria-labelledby="modalbus" aria-hidden="true">
<div class="modal-dialog " role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="modalbus">Add Bus</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form action="<?= base_url()?>bus/save" method="post">
      <div class="form-group">
        <label for="bus_name" class="">Bus Name</label>
        <input type="text" class="form-control" name="bus_name" placeholder="Bus Name">
      </div>
      <div class="form-group">
        <label for="platbus" class="">Bus Number Plate</label>
        <input type="text" class="form-control" name="bus_plate" placeholder="Bus Plate">
      </div>
      <div class="form-group">
        <label for="seat" class="">Number of Seats</label>
        <input type="number" class="form-control" id="bus_capacity" name="bus_capacity" placeholder="[Maximum 23]">
      </div>
      <div class="modal-footer">
        <div  class="btn-group">
        <button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;Save</button>
          <button type="button" class="btn  btn-danger" data-dismiss="modal"><i class="fas fa-close"></i>&nbsp;Close</button>
          
      </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<!-- js -->
<?php $this->load->view('backend/include/base_js'); ?>
</body>
</html>