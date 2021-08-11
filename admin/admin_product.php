<?php
session_start();
require 'adminFunction.php';
$_SESSION['page'] = 'product';
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Management</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="..//css//adminCP.css">
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', () => {
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, location.href);
                }

                //Refocus on the 1st input box after reset the form
                document.querySelector('#reset').onclick = () => {
                    document.querySelector('input').focus();
                }
                //Validate category, a provided category must be selected before submitting new product
                var ctg = document.querySelector('#ctg');
                document.querySelector('#addproduct').onsubmit = (event) => {
                    if (ctg.value === 'select...') {
                        event.preventDefault();
                        alert('You must specify a category for the product.');
                        ctg.focus();
                    }
                }
                //Validate price (decimal number, greater than zero) before submitting new product
                var price = document.querySelector('#price');
                var priceCheck = /^[-+]?[0-9]*\.?[0-9]+$/;
                price.onblur = () => {
                    if (price.value.length > 0) {
                        if (priceCheck.test(price.value) === false || price.value < 0) {
                            alert('You must enter positive decimal number for unit price.');
                            price.value = '';
                            price.focus();
                        }
                    }
                }
                //Validate quantity (integer number, greate than zero) before submitting new product
                var quantity = document.querySelector('#quantity');
                var quantityCheck = /^[0-9]*$/;
                quantity.onblur = () => {
                    if (quantity.value.length > 0) {
                        if (quantityCheck.test(quantity.value) === false) {
                            alert('You must enter positive integer number for initial quantity.');
                            quantity.value = '';
                            quantity.focus();
                        }
                    }
                }
            });

            // jquery ajax function
            $(document).ready(function() {
                //get product detail for edit:
                $('.edit-product').click(function() {
                    var productID = $(this).attr("data-id"); //get the value of the attribute 'data-id' from the button when click
                    $.ajax({
                        url: "queryProduct.php",
                        method: "post",
                        data: {
                            product: productID
                        }, //the request name is 'Product' and the value to be sent is the variable 'productID'
                        success: function(data) { //with the data responsed from server, insert into the div id 'product-detail' and show the modal
                            $('#product-detail').html(data);
                        }
                    });
                });
            });
        </script>
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
                    <a href="">
                        <li style="background-color: rgb(30, 126, 67);">
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
                <h2>Product Management</h2>
                <div class="collapse product add" id="addproduct">
                    <h4>Add new product</h4>
                    <form id="addproduct" action="addProduct.php" method="post" enctype="multipart/form-data">
                        <div class="input-group mb-1">
                            <span class="input-group-text" style="max-width:20%">Product name:</span>
                            <input type="text" id="pname" class="form-control" name="pname" placeholder="" aria-label="pname" required>
                            <span class="input-group-text">Category:</span>
                            <select class="form-select" name="category" id="ctg">
                                <option value="select:">select...</option>
                                <?php
                                $conn = connect();
                                $list = $conn->query("SELECT categoryName FROM category");
                                if ($list->num_rows > 0) {
                                    while ($item = $list->fetch_assoc()) {
                                        echo "<option value=\"{$item['categoryName']}\">{$item['categoryName']}</option>";
                                    }
                                }
                                $conn->close();
                                ?>
                            </select>
                            <button type="button" class="form-control btn btn-outline-secondary" style="max-width: 12%" data-bs-toggle="modal" data-bs-target="#categoryPanel">
                                <i class="fa fa-folder-open" aria-hidden="true"></i>
                                <b>New</b>
                            </button>

                            <!-- <input type="button" value="New Category" class="form-control btn btn-secondary"> -->
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" style="max-width:11%">Unit price:</span>
                            <span class="input-group-text" style="max-width:5%"><i class="fa fa-usd" aria-hidden="true"></i></span>
                            <input type="text" id="price" class="form-control" name="price" placeholder="" aria-label="price" required>
                            <span class="input-group-text">Initial Stock:</span>
                            <input id="quantity" type="text" class="form-control" name="quantity" placeholder="" aria-label="quantity" required>
                        </div>
                        <div class="form-floating mb-3">
                            <!-- <span class="input-group-text">Description:</span> -->
                            <textarea id="detail" style="height: 100px" class="form-control" name="detail" aria-label="detail" required></textarea>
                            <label for="detail">Product detail</label>
                        </div>
                        <!-- image upload -->
                        <h6></h6>
                        <div class="mb-3">
                            <label for="customFile">Picture:</label>
                            <input style="max-width:50%" type="file" class="form-control" id="customFile" name="avatar" accept="image/*" />
                            <small id="imgHelp" class="form-text text-muted">Accept only JPG, PNG and GIF image
                                files.</small>
                        </div>

                        <!-- submit -->
                        <div class="submit input-group mb3">
                            <input class="btn-add btn btn-primary" type="submit" value="Add" name="add" id="add">
                            <button class="btn-add btn btn-danger" type="reset" id="reset">Reset</button>
                        </div>
                    </form>
                </div>
                <br>

                <div class="product list">
                    <div class="row" style="padding: 5px;">
                        <div class="col">
                            <form action="" method="post">
                                <div class="input-group">
                                    <span class="input-group-text">Sort by:</span>
                                    <button type="submit" name="sortname" class="btn btn-outline-secondary">Name</button>
                                    <button type="submit" name="sortcat" class="btn btn-outline-secondary">Category</button>
                                    <button type="submit" name="sortnew" class="btn btn-outline-secondary">Newest</button>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <a class="btn btn-warning" data-bs-toggle="collapse" href="#addproduct" role="button" aria-expanded="false" aria-controls="addproduct"><i class="fa fa-plus" aria-hidden="true"></i> Add product</a>
                        </div>
                        <div class="col">
                            <form action="" method="post" id='search'>
                                <div class="input-group">
                                    <input style="max-width:90%" type="search" class="form-control src" name="searchvalue" id="searchbar" placeholder="Search">
                                    <button class="btn btn-outline-success" type="submit" name="search" id='src-submit'>
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="display">
                        <!-- display product list from database -->
                        <?php
                        $search = '';
                        if (isset($_POST['sortname'])) {
                            $order = 'ORDER BY productName';
                            admin_displayProduct($search, $order);
                        } elseif (isset($_POST['sortcat'])) {
                            $order = 'ORDER BY categoryName, productID DESC';
                            admin_displayProduct($search, $order);
                        } elseif (isset($_POST['sortnew'])) {
                            $order = 'ORDER BY productID DESC';
                            admin_displayProduct($search, $order);
                        } else {
                            if (isset($_POST['search'])) {
                                $search = $_POST['searchvalue'];
                                admin_displayProduct($search, 'ORDER BY categoryName, productID DESC');
                            } else {
                                admin_displayProduct('', 'ORDER BY categoryName, productID DESC');
                            }
                        }
                        ?>
                    </div>
                    <!-- Update product -->
                    <form id='mng-product' action='updateproduct.php' method='post' enctype='multipart/form-data'>
                        <div class="modal fade" id="editPanel" tabindex="-1" aria-labelledby="editPanelLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="editPanelLabel">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                            Update Product
                                        </h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="product-detail">
                                        <!-- query.php fetchs data here -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="Save changes" name="save" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Add Category -->
                    <form id='add-cat' action='AddCategory.php' method='post'>
                        <div class="modal fade" id="categoryPanel" tabindex="-1" aria-labelledby="categoryPanelLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="categoryPanelLabel">
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
            <!-- display message -->
            <?php
            if (isset($_SESSION['error'])) {
                echo "<script>alert('{$_SESSION['error']}')</script>";
                unset($_SESSION['error']);
            }

            if (isset($_SESSION['errUpdate'])) {
                echo "<script>alert('Update FAILED! Please check the following error(s):\\n";
                foreach ($_SESSION['errUpdate'] as $value) {
                    echo " - " . $value . "\\n";
                }
                echo "')</script>";
                unset($_SESSION['errUpdate']);
            }

            if (isset($_SESSION['success'])) {
                echo "<script>alert('{$_SESSION['success']}')</script>";
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