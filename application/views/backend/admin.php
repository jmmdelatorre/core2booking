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
    <!-- navbar -->
    <?php $this->load->view('backend/include/base_nav'); ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <h1 class="h5 mb-2 text-gray-800">List of System Administrators</h1>
      <!-- DataTales Example -->
      <!-- Log on to codeastro.com for more projects -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
           <a href="<?= base_url('backend/admin/save') ?>" class="btn btn-success pull-right" >
           Add Access Account
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table  table-condensed table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Admin Code</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Level</th>
                  <th>View</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1;foreach ($admin as $row) { ?>
                  <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['id_admin']; ?></td>
                    <td><?= $row['name_admin']; ?></td>
                    <td><?= $row['username_admin']; ?></td>
                    <td><?= $row['email_admin']; ?></td>
                    <td><?php if ($row['level_admin'] == '1') { ?>
                      Superadmin
                    <?php }else{ ?>
                      Administrator
                    <?php } ?>
                    </td>
                    <td><a href="<?= base_url('backend/admin/view/'.$row['id_admin']) ?>" class="btn btn-sm btn-info">View</a></td>
                    <?php if ($row['id_admin'] === 'ADM0006') { ?> 
                      <td></td>
                    <?php }else {?>
                      <td>
                      <a href="javascript:void(0);" 
                          data-id="<?= $row['id_admin']; ?>" 
                          class="btn btn-sm btn-danger delete-admin">Delete</a>
                    </td>
                    
                    
                      <?php } ?>
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
</div>
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<script>
$(document).on('click', '.delete-admin', function(e) {

    e.preventDefault();
    var id_admin = $(this).data('id');
    var deleteUrl = '<?= base_url('backend/admin/delete'); ?>/' + id_admin;

    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                  Swal.fire(
                            'Deleted!',
                            'Admin has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was an error processing your request.',
                        'error'
                    );
                }
            });
        }
    });
});
</script>




</body>
</html>