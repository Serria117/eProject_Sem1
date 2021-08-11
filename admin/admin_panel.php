<?php
session_start();
require 'adminFunction.php';
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, location.href);
            }
            $(document).ready(function () {
                $('.order-detail').click(function(){
                    var orderID = $(this).attr("data-id");
                    $.ajax({
                        type: "post",
                        url: "orderDetail.php",
                        data: {order:orderID},
                        success: function (data) {
                            $('#order-detail').html(data);
                        }
                    });
                })
            });
        </script>
        <link rel="stylesheet" href="..//css//adminCP.css">
    </head>

    <body>

        <div class="container-fluid">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4><i class="fa fa-star-o icon" aria-hidden="true"></i>STAR ORGANIC</h4>
                </div>
                <ul class="menu">
                    <!-- <a href=""> -->
                    <li class="account">
                        <div style="background: #103814; padding:20px; border-radius: 10px">
                            <span class="icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                            <span class="text">User: <?= $_SESSION['userName'] ?></span>
                        </div>
                    </li>
                    <!-- </a> -->
                    <a href="admin_panel.php">
                        <li style="background-color: rgb(30, 126, 67);">
                            <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                            <span class="text">Home</span>
                        </li>
                    </a>
                    <a href="admin_Order.php">
                        <li>
                            <span class="icon"><i class="fa fa-th-list" aria-hidden="true"></i></span>
                            <span class="text">Manage Order</span>
                        </li>
                    </a>
                    <a href="admin_product.php">
                        <li>
                            <span class="icon"><i class="fa fa-product-hunt" aria-hidden="true"></i></span>
                            <span class="text">Manage Product</span>
                        </li>
                    </a>
                    <a href="admin_Category.php">
                        <li>
                            <span class="icon"><i class="fa fa-folder-open" aria-hidden="true"></i></span>
                            <span class="text">Manage Category</span>
                        </li>
                    </a>
                    <a href="admin_User.php">
                        <li>
                            <span class="icon"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>
                            <span class="text">Manage User</span>
                        </li>
                    </a>
                    <a href="admin_Customer.php">
                        <li>
                            <span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <span class="text">Manage Customer</span>
                        </li>
                    </a>
                    <a href="logout.php" onclick="return confirm('Do you want to log out?')">
                        <li class="logout">
                            <span class="icon"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                            <span class="text">LOG OUT</span>
                        </li>
                    </a>
                </ul>
            </div>

            <div class="content">
                <h2>Dashboard</h2>
                <div class='row container justify-content-center'>
                    <div class="col ">
                        <div class="stat-user">
                            <div class="text">
                                Customer
                            </div>
                            <div class="number">
                                <i class="fa fa-male" aria-hidden="true"></i>
                                <?php echo totalCustomer() ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-lsale">
                            <div class="text">
                                Today Orders
                            </div>
                            <div class="number">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                <?= number_format(admin_countOrder()) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-csale">
                            <div class="text">
                                Today Sale
                            </div>
                            <div class="number">
                                $<?= number_format(admin_saleValue(date('Y-m-d'))) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-total">
                            <div class="text">
                                Total Sale
                            </div>
                            <div class="number">
                                $<?= number_format(admin_saleValue('')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="list">
                    <h3>Order queue</h3>
                    <?php
                    admin_displayOrder();
                    ?>
                </div>
                <form id='mng-product' action='processOrder.php' method='post' enctype='multipart/form-data'>
                    <div class="modal fade" id="process" tabindex="-1" aria-labelledby="processLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="processLabel">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                        Order Details
                                    </h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="order-detail">
                                    <!-- query.php fetchs data here -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- <input type="submit" value="Save changes" name="save" class="btn btn-primary"> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    header("location: index.php");
}
?>