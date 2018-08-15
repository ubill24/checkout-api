<div class="container">
    <br><br>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php
                        $order_code = '061386082';
                        $customer_name = 'Jennifer Williams';
                        $order_date = date("m-d-y");
                        $amount = '5';
                        $description='Checkout from e-commerce website.';
                        $api_token = '65d9c9899eb54fef9afb4e44f10cdc21';
                    ?>
                    <h1 class="text-center text-primary">Order Confirmation</h1>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div id="order_code-barcode"></div>
                            <h2> <?php echo $order_code ?></h2>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-right">
                                <?php echo $customer_name ?>
                                <i class="fa fa-user-tie" style="width: 32px;"></i>
                            </h6>
                            <h6 class="text-right">
                                <?php echo $order_date ?>
                                <i class="fa fa-calendar-alt" style="width: 32px;"></i>
                            </h6>
                        </div>
                    </div>
                    <br><br>

                    <form action="checkout.php" method="post">

                        <input type="hidden" id="order_code" name="order_code" value="<?php echo $order_code ?>">
                        <input type="hidden" id="order_date" name="order_date" value="<?php echo $order_date ?>">
                        <input type="hidden" id="customer_name" name="customer_name" value="<?php echo $customer_name ?>">
                        <div class="form-group row">
                            <label for="api_token" class="col-sm-3 col-form-label">API Token</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="api_token" name="api_token" value="<?php echo $api_token ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label">Amount</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $amount ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="currency" class="col-sm-3 col-form-label">Currency</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="currency" name="currency">
                                    <option value="USD">USD</option>
                                    <option value="KHR">KHR</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="description" name="description"><?php echo $description ?></textarea>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary float-right">Check Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>