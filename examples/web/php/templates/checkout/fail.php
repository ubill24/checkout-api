<?php include 'templates/header.php'; ?>
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
                            <td>{{ error_code }}</td>
                        </tr>
                        <tr>
                            <th>Error Message</th>
                            <td>{{ error_message }}</td>
                        </tr>
                    </table>
                    <a role="button" class="btn btn-outline-primary" href="{{ url_for('order_confirm') }}">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/footer.php' ?>

