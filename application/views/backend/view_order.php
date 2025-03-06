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
    <h2 class=" text-gray-800">Passenger List</h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Passenger list</h6>
                <a href="<?= base_url('backend/order'); ?>" class="btn btn-danger">Back</a>
            </div>
            <div class="card-body">
                <table class="table  table-condensed table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Purchase Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Ticket</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($passenger as $row) { ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= date('m/d/Y h:i A', strtotime($row['created_at'])); ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['fare']; ?></td>
                            <td>
                                <a href="<?= base_url('backend/order/check_ticket/'.$row['order_code']) ?>"
                                    class="btn btn-primary btn-sm">Show ticket</a>
                            </td>
                            <td>
                                <a href="<?= base_url('backend/order/check_ticket/'.$row['order_code']) ?>"
                                    class="btn btn-danger btn-sm">Cancel/Refund</a>
                            </td> 
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php $this->load->view('backend/include/base_footer'); ?>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php $this->load->view('backend/include/base_js'); ?>
</body>

</html>