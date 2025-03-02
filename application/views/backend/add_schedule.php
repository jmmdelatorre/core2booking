<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/frontend/timepicker') ?>/css/bootstrap-material-datetimepicker.css" />
    <?php $this->load->view('backend/include/base_css'); ?>
  </head>
  <body id="page-top">

    <?php $this->load->view('backend/include/base_nav'); ?>

    <div class="container-fluid">
  
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Add Schedule</h6>
        </div>
        <div class="card-body">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <form action="<?= base_url()?>schedule/save" method="post">
                  <div class="form-group">
                    <label class="">Terminal Origin</label>
                    <select class="form-control" name="terminal_departure" required>
                      <option value="" selected disabled="">-Choose Origin-</option>
                      <?php foreach ($terminal as $row ) {?>
                      <option value="<?= $row['terminal_id'] ?>" ><?= strtoupper($row['terminal_id'])." - ".$row['terminal_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="">Terminal Arrival</label>
                    <select class="form-control" name="terminal_arrival" required>
                      <option value="" selected disabled="">-Choose Destination-</option>
                      <?php foreach ($terminal as $row ) {?>
                      <option value="<?= $row['terminal_id'] ?>" ><?= strtoupper($row['terminal_id'])." - ".$row['terminal_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label  class="">Bus</label>
                    <select class="form-control" name="bus">
                      <option value="" selected disabled="">-Choose Bus-</option>
                      <?php foreach ($bus as $row ) {?>
                      <option value="<?= $row['bus_id'] ?>" ><?= strtoupper($row['bus_name']); ?> </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label  class="">Departure Date</label>
                    <input type="date" class="form-control"  id="time" name="departure_date" required="" placeholder="Departure Hours">
                  </div>
                  <div class="form-group">
                    <label  class="">Departure Hours</label>
                    <input type="time" class="form-control"  id="time" name="departure_time" required="" placeholder="Departure Hours">
                  </div>
                  <div class="form-group">
                    <label  class="">Arrival Hour</label>
                    <input type="time" class="form-control"  id="time2" name="arrival_time" required="" placeholder="Arrival Hour">
                  </div>
                  <div class="form-group">
                    <label  class="">Fare</label>
                    <input type="number" class="form-control" name="fare" required="" placeholder="Price">
                    <?= form_error('name'),'<small class="text-danger pl-3">','</small>'; ?>
                  </div>
                </div>
              </div>
              <hr>
              <a class="btn btn-danger" href="<?= base_url('schedule') ?>"> Go Back</a>
              <input  type="submit" class="btn btn-success pull-rigth" value="Add Schedule">
            </form>
          </div>
        </div>
      </div>
    </div>
   
    <?php $this->load->view('backend/include/base_footer'); ?>
  
        <?php $this->load->view('backend/include/base_js'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
        <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/frontend/timepicker') ?>/js/bootstrap-material-datetimepicker.js"></script>
        <script type="text/javascript">
          $(document).ready(function()
          {
            $('#time').bootstrapMaterialDatePicker
            ({
              date: false,
              shortTime: false,
              format: 'HH:mm'
            });
          })
        </script>
        <script type="text/javascript">
          $(document).ready(function()
          {
            $('#time2').bootstrapMaterialDatePicker
            ({
              date: false,
              shortTime: false,
              format: 'HH:mm'
            });
          })
        </script>

      </body>
    </html>