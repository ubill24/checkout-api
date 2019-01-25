<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Bill 24 | Checkout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
        <link type="text/css" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link type="text/css" rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <?php 
            require_once 'checkout_cancel.php';
            $scriptPath = dirname(__FILE__);
            $path = realpath($scriptPath . '/./');
            $filepath = explode("wp-content",$path);
            // print_r($filepath);
            define('WP_USE_THEMES', false);
            require(''.$filepath[0].'/wp-blog-header.php');
            require(''.$filepath[0].'/wp-load.php');
            
            ?>
        <div class="container">
            <br><br>
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="text-center text-primary">Failed</h1>
                            <hr>
                            <table class="table">
                                <tr>
                                    <th>Error Code</th>
                                    <td><?php echo $error_code ?></td>
                                </tr>
                                <tr>
                                    <th>Error Message</th>
                                    <td><?php echo $error_message?></td>
                                </tr>
                            </table>
                            <a role="button" class="btn btn-outline-primary" href="<?php echo get_home_url(); ?>">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    </body>
</html>

<?php
   sleep(10);
   wp_redirect(home_url());
?>
