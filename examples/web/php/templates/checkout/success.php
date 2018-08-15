<?php include 'templates/header.php'; ?>
<?php require_once 'checkout_confirm.php'?>
<div class="container">
    <br><br>
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center text-primary">Successful</h1>
                    <hr>
                    <div class="row">
                        <div class="col-sm-5 text-center">
                            <i class="far fa-5x fa-check-circle text-success"></i>
                            <br><br><br>
                            <p class="lead">Thank you for your purchase!</p>
                            <br>
                            <a role="button" class="btn btn-outline-primary" href="index.php">Continue Shopping</a>
                        </div>
                        <div class="col-sm-7">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Transaction No.</th>
                                    <td><?php echo $data->tran_id ?></td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td><?php echo $data->tran_date ?></td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td class="text-right">
                                        <?php echo $data->tran_amount ?>
                                        <span class="badge badge-primary"><?php echo $data->currency ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fee Amount</th>
                                    <td class="text-right">
                                        <?php echo $data->fee_amount ?>
                                        <span class="badge badge-primary"><?php echo $data->currency ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td class="text-right">
                                        <?php echo $data->total_amount ?>
                                        <span class="badge badge-primary"><?php echo $data->currency ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bank Reference No.</th>
                                    <td><?php echo $data->bank_reference_no ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/footer.php' ?>

