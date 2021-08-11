<?php
session_start();
require 'adminFunction.php';
$_SESSION['page'] = 'category';
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Account Management</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, location.href);
            }
            $(document).ready(function() {
                $('.edit-user').click(function() {
                    var userID = $(this).attr("data-id");
                    $.ajax({
                        url: "queryUser.php",
                        method: "post",
                        data: {
                            user: userID
                        },
                        success: function(data) {
                            $('#user-detail').html(data);
                        }
                    });
                });
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
                        <li>
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
                        <li style="background-color: rgb(30, 126, 67);">
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
                <h2>Category Management</h2>

                <div class="cat list row">
                    <div class="col title" style="padding-bottom:10px;">
                        <h4>Category list</h4>
                    </div>
                    <div class="col">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editPanel">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            New Category
                        </button>
                    </div>
                    <div class="col">
                        <form action="" method="get" class="src-form form-group">
                            <div class="search-bar input-group">
                                <input name="searchvalue" type="search" id="searchbar" class="form-control src" placeholder="Search" />
                                <button class="btn btn-outline-success" type="submit" name="search" id='src-submit'>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="display">
                        <!-- display user list from database -->
                        <?php
                        admin_displayCategory();
                        ?>
                    </div>
                </div>
                <!-- Add Category -->
                <form id='add-cat' action='AddCategory.php' method='post'>
                    <div class="modal fade" id="editPanel" tabindex="-1" aria-labelledby="editPanelLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="editPanelLabel">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                        Create new Category
                                    </h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="category-add">
                                    <div class="input-group mb-3">
                                        <span class='input-group-text'>Category name:</span>
                                        <input type="text" name="cname" id="" class='form-control'>
                                        <span class='input-group-text'>Unit:</span>
                                        <input type="text" name="cunit" id="" class='form-control'>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class='input-group-text'>Description:</span>
                                        <textarea type="text" name="detail" id="" class='form-control'></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <input type="submit" value="Create" name="create" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        if (isset($_SESSION['error1'])) {
            echo "<script>alert('{$_SESSION['error1']}')</script>";
            unset($_SESSION['error1']);
        }

        if (isset($_SESSION['error2'])) {
            echo "<script>alert('Operation FAILED! Please check the following error(s):\\n";
            foreach ($_SESSION['error2'] as $value) {
                echo " - " . $value . "\\n";
            }
            echo "')</script>";
            unset($_SESSION['error2']);
        }

        if (isset($_SESSION['success'])) {
            echo "<script>alert('{$_SESSION['success']}')</script>";
            print_r($_SESSION['success']);
            unset($_SESSION['success']);
        }
        ?>
    </body>

    </html>


<?php
} else {
    header("location: index.php");
}
?>