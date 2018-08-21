<?php include 'templates/header.php'; ?>
<?php require_once 'pay_later.php'?>
<div class="container">
    <br><br>
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 logo">
                            <?php
                                echo "<img src='./images/logo.jpg' alt='logo' />";
                            ?>
                            <br>
                            <div>
                                <span><b>Invoice No :</b></span>
                                <span class="bill-code"><?php echo $data->bill_code ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right invoice-header">
                            <h4>WR Phone Shop</h4>
                            <br>
                            <p>
                                #88F, st.218, Sangkat Toek Loark 3,
                                <br>Khan Toul Kork, Phnom Penh
                                <br>012 345 678/ 096 765 432
                                <br>wr.phoneshop@gmail.com
                            </p>
                        </div>
                    </div>
                    <hr style="width: 90%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Reference No.</th>
                            <th scope="col">Bill Date</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row"><?php echo $data->reference_id ?></th>
                            <td><?php echo $data->bill_date ?></td>
                            <td><?php echo $data->description ?></td>
                            <td><?php echo $data->amount ?><span class="badge badge-primary"><?php echo $data->currency ?></span></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="payment-box">
                        <div class="qrcode">
                            <div id="payment-url-qrcode"></div>
                            <strong class="payment-title">Payment Link:</strong><br/>
                            <span class="payment-description">You can use this QR code to mak a payment via B24 online app.</span>
                        </div>
                        <div class="agencies">
                            <strong class="agencies-title">Pay with agencies:</strong>
                            <div class="agencies-img">
                                <?php
                                    $agencies =  $data->biller_codes;
                                    foreach( $agencies as $agency ) {
                                        echo "<img src='$agency'>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="print text-center">
                        <a href="#"> <?php echo "<img src='./images/printer.png'​​>" ?></a>
                        <a href="#"><?php echo "<img src='./images/pdf.png'>" ?></a>
                        <a href="index.php"> <?php echo "<img src='./images/home.png'>" ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#payment-url-qrcode").qrcode({
            render: "image",
            width: 120,
            height: 120,
            text: "<?php $data->payment_url ?>"
        });

    });
</script>
<?php include 'templates/footer.php' ?>
