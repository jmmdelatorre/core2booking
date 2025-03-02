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
    <!-- navbar --><!-- Log on to codeastro.com for more projects -->
    <?php $this->load->view('backend/include/base_nav'); ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <h2 class="text-gray-800">Destination/Terminal Management</h2>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#ModalTujuan">
          Add Destination
          </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table  table-condensed table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr align="center">
                  <th>#</th>
                  <th>Code</th>
                  <th>Terminal name</th>
                  <th>Departure</th>
                  <th>Arrival</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ; foreach ($tujuan as $row ) { ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $row['terminal_id']; ?></td>
                  <td><?=  substr($row['terminal_name'], 0, 15); ?></td>
                  <td><?= strtoupper($row['departure']); ?></td>
                  <td><?= strtoupper($row['arrival']); ?></td>
                  
                  <td align="center"><a href="<?= base_url('backend/rute/viewrute/'.$row['terminal_id']) ?>" class="btn btn-info">View</a></td>
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
<!-- Modal -->
<div class="modal fade" id="ModalTujuan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add Terminal</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="<?= base_url() ?>terminal/save" method="post" > 
      <div class="form-group">
    <label for="exampleInputEmail1">Terminal</label>
       <input name="terminal_name" class="form-control" placeholder="Terminal name">
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1">Departure</label>
        <select name="departure"  class="form-control selCity" required>
            <option value="">Choose Origin</option>
        </select>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Destination</label>
        <select name="arrival" class="form-control  selCity">
            <option value="">Choose Destination</option>
        </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Status</label>
        <select name="terminal_status"  class="form-control" required>
            <option value="" selected disabled="">Status</option>
            <option value="A">Active</option>
            <option value="I">Inactive</option>
        </select>
    </div>
        <div class="modal-footer">
        <button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;Save</button>
        <button type="button" class="btn  btn-danger" data-dismiss="modal"><i class="fas fa-close"></i>&nbsp;Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- js -->
<?php $this->load->view('backend/include/base_js'); ?>
<script>
        $(".selCity").select2({
        enabled: true,
        placeholder: "City",
      
        allowClear: true,
        ajax: {
            url: "DemographicsController/searchCity",
            dataType: "JSON",
            type: "POST",
            delay: 250,
            data: function (params) {
                return { searchCity: params.term };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return { id: item.ctycode, text: item.ctyname };
                    }),
                };
            },
        },
    });
    </script>
</body>
</html>