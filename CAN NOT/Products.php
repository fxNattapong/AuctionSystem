<?php
include('../Assets/Session.php');
$objConnect = mysqli_connect("localhost","root","")or die("Can't connect to database");
$db = mysqli_select_db($objConnect, "dbAuction");
mysqli_query($objConnect, "SET NAMES utf8");

if($objConnect->connect_error) {
    die("Connection failed". $conn->connect_error);
}

$strSQL = "SELECT * FROM members WHERE member_username = '".$_SESSION['member_username']."' ";
$objQuery = mysqli_query($objConnect, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

$query = "SELECT * FROM products";
$query_run = mysqli_query($objConnect, $query);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <title>CENTER AUCTION SYSTEM</title>
        <link rel="stylesheet" href="../css/styles-products.css">
    </head>

    <body>
        <!-- Navbar  -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
            <div class="container">
                <img src="../img/logo.png" class="imgLogo">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav navbar-margin">
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="Index.php">Home</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="#">Categories</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="#">Payment</a>
                        </li>
                        <?php if(isset($_SESSION['member_username'])): ?>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="#">Products</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if(isset($_SESSION['member_username'])): ?>
                    <li class=" btn-logout-position">
                        <a class="nav-link dropdown-toggle btn-logout" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome - <?php echo $_SESSION['member_username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-white" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Manage Account</a></li>
                            <li><a class="dropdown-item" href="../Assets/Logout.php">Logout</a></li>
                        </ul>
                    </li> 
                <?php else: ?>
                    <button type="button" class="btn btn-primary mx-auto show-modal" data-bs-toggle="modal" data-bs-target="#sign-in">LOGIN</button>
                <?php endif; ?>
            </div>
        </nav>
        
        <!-- Banner Image  -->
        <div class="bg-image2"></div>
        <!-- Script Scrolled -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">
        var nav = document.querySelector('nav');

        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 100) {
            nav.classList.add('scrolled', 'shadow');
            } else {
            nav.classList.remove('scrolled', 'shadow');
            }
        });
        </script>

        <!-- Main Content Area -->
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="row mb-4 mt-4">
                    <div class="col-md-12">
                        
                    </div>
                </div>
                <div class="row card-table">
                    <!-- FORM Panel -->

                    <!-- Table Panel -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b style="font-size: 24px;">LIST YOUR PRODUCTS</b>
                                <span><a><button type="button" class="btn btn-primary create" href="#" style="float: right;">CREATE NEW</button></a></span>
                            </div>
                            <div class="card-body">
                                <table class="table table-condensed table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="">IMG</th>
                                            <th class="">CATEGORY</th>
                                            <th class="">PRODUCT</th>
                                            <th class="">OTHER INFO</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if($query_run) {
                                        ?>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            $cat = array();
                                            $cat[] = '';
                                            $qry = mysqli_query($objConnect, "SELECT * FROM categories");
                                            while($row = $qry->fetch_assoc()){
                                                $cat[$row['category_id']] = $row['category_name'];
                                            }
                                            $products = mysqli_query($objConnect, "SELECT * FROM products 
                                                                                    WHERE product_created_by = '".$_SESSION['member_username']."' 
                                                                                    ORDER BY product_name asc");
                                            while($row = $products->fetch_assoc()):
                                                $get = mysqli_query($objConnect, "SELECT * FROM bids where bid_product_id = {$row['product_id']} order by bid_amount desc limit 1");
                                                $bid = $get->num_rows > 0 ? $get->fetch_array()['bid_amount'] : 0 ;
                                                $tbid = mysqli_query($objConnect, "SELECT distinct(bid_user_id) FROM bids where bid_id = {$row['product_id']} ")->num_rows;
                                            ?>
                                            <tr data-id= '<?php echo $row['product_id'] ?>'>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <?php $product_img = $row['product_img']; ?>
                                                        <img height="100" src='<?php echo $product_img; ?>'>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p><b><?php echo ucwords($cat[$row['product_category_id']]) ?></b></p>
                                                </td>
                                                <td>
                                                    <p>Name: <b><?php echo ucwords($row['product_name']) ?></b></p>
                                                    <p>Description: <b><?php echo $row['product_desc'] ?></b></p>
                                                </td>
                                                <td>
                                                    <p>Start Price: <b><?php echo number_format($row['product_start_bid'],2) ?></b></p>
                                                    <p>End Date/Time: <b><?php echo date("M d,Y h:i A",strtotime($row['product_end_bid'])) ?></b></p>
                                                    <p>Latest Bid: <b class="highest_bid"><?php echo number_format($bid,2) ?></b></p>
                                                    <p>Total Bids: <b class="total_bid"><?php echo $tbid ?> user/s</b></p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary edit" type="button" 
                                                            data-id="<?php echo $row['product_id'] ?>" data-name="<?php echo $row['product_name'] ?>" 
                                                            data-categories="<?php echo $row['product_category_id'] ?>" data-desc="<?php echo $row['product_desc'] ?>"
                                                            data-startbid="<?php echo $row['product_start_bid'] ?>" data-endbid="<?php echo $row['product_end_bid'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-id="<?php echo $row['product_id'] ?>">DELETE</button>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                        <?php
                                    
                                    } else {
                                        echo "NOT FOUND ANY PRODUCTS";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Table Panel -->
                </div>
            </div>
        </div>

        <!-- Modal Create -->
        <div class="modal fade" id="productsCreate" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <?php
            ?>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body form-align-products">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <form name="formCreateProduct"  method="post" action="ProductsCreate.php" enctype="multipart/form-data">
                            <h4><b>CREATE NEW PRODUCT</b></h4>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label">NAME</label>
                                    <input type="text" class="form-control form-create-products" name="product_name"  value="<?php echo isset($product_name) ? $product_name :'' ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <label class="control-label">CATEGORY</label>
                                    <select class="form-select form-create-products" name="product_category_id">
                                        <option value=""></option>
                                        <?php
                                        $qry = mysqli_query($objConnect, "SELECT * FROM categories order by category_name asc");
                                        while($row=$qry->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['category_id'] ?>" <?php echo isset($category_id) && $category_id == $row['category_id'] ? 'selected' : '' ?>><?php echo $row['category_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label">DESCRIPTION</label>
                                    <textarea name="product_desc" id="product_desc" form="formCreateProduct" method="post" class="form-control" cols="30" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="control-label">STARTING BIDDING AMOUNT</label>
                                    <input type="number" name="product_start_bid" id="product_start_bid" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">BIDDING END DATE/TIME</label>
                                    <input type="datetime-local" name="product_end_bid" id="product_end_bid" class="form-control datetimepicker" onchange="displayImg(this,$(this))">
                                </div>
                                <div class="col-md-5">
                                    <img src="<?php echo isset($product_img) ? 'assets/uploads/'.$product_img :'' ?>" alt="" id="img_path-field">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label">PRODUCT IMAGE</label>
                                    <input type="file" name="product_img" id="product_img" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="product_created_by" id="product_created_by" value="<?php echo $_SESSION['member_username']; ?>" readonly>
                            <hr>
                            <div>
                                <button type="submit" class="btn">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="productsEdit" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <?php
            $qry = $conn->query("SELECT * FROM products where product_id = ".$_GET['product_id']);
            if(isset($_GET['product_id'])){
                $qry = $conn->query("SELECT * FROM products where product_id = ".$_GET['product_id']);
                foreach($qry->fetch_array() as $k => $val){
                    $$k=$val;
                }
            }
            ?>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body modal-content clearfix form-align-products">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <form name="formEditProduct" id="formEditProduct" method="post" action="ProductsEdit.php" enctype="multipart/form-data">
                            <input type="text" name="product_id" id="product_id" value="">
                            <h4><b>EDIT PRODUCT</b></h4>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">NAME</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="" class="control-label">CATEGORY</label>
                                    <select class="form-select form-create-products" name="category_id">
                                        <option value=""></option>
                                        <?php
                                        $qry_categories = mysqli_query($objConnect, "SELECT * FROM categories order by category_name asc");
                                        while($row=$qry_categories->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['category_id'] ?>" <?php echo isset($category_id) && $category_id == $row['category_id'] ? 'selected' : '' ?>><?php echo $row['category_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">DESCRIPTION</label>
                                    <input type="text" name="product_desc" id="product_desc" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">STARTING BIDDING AMOUNT</label>
                                    <input type="number"  name="product_start_bid" id="product_start_bid" class="form-control" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">BIDDING END DATE/TIME</label>
                                    <input type="datetime-local" name="product_end_bid" id="product_end_bid" class="form-control datetimepicker" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">PRODUCT IMAGE</label>
                                    <input type="file" class="form-control" name="img" onchange="displayImg2(this,$(this))">
                                </div>
                                <div class="col-md-5">
							        <img src="<?php echo isset($product_img) ? 'assets/uploads/'.$product_img :'' ?>" alt="" id="img_path-field">
						        </div>
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.create').on('click', function () {
                    $('#productsCreate').modal('show');
                });
                $('.edit').on('click', function () {
                    $('#product_id').val($(this).data('id'));
                    $('#product_name').val($(this).data('name'));
                    $('#product_categories').val($(this).data('categories'));
                    $('#product_desc').val($(this).data('desc'));
                    $('#product_start_bid').val($(this).data('startbid'));
                    $('#product_end_bid').val($(this).data('endbid'));
                    $('#productsEdit').modal('show');
                });
            });
            function displayImg(input,_this) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img_path-field').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <style>
            td{
                vertical-align: middle !important;
            }
            td p{
                margin: unset
            }
            table td img{
                max-width: 100px;
                max-height: :150px;
            }
            img{
                max-width: 100px;
                max-height: 150px;
            }
        </style>
        
         <!-- FOOTER -->
        <footer class="w-100 py-4 flex-shrink-0">
            <div class="container py-3">
                <div class="row gy-4 gx-5 row justify-content-md-center">
                    <div class="col-lg-2 col-md-6">
                        <h5 class="text-white mb-3">Quick links</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Shope</a></li>
                            <li><a href="#">Vendor</a></li>
                            <li><a href="#">Payment</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <h5 class="text-white mb-3">Quick links</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Contract us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <h5 class="text-white mb-3">Quick links</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#">Cart</a></li>
                            <li><a href="#">Shop Listing</a></li>
                            <li><a href="#">List View</a></li>
                            <li><a href="#">Single Post</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-3">Subscribe</h5>
                        <p class="small text-muted">Get digital marketing updates in your mailbox.</p>
                        <form action="#">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" placeholder="Enter email address">
                                <button type="submit" class="btn btn-primary">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="bg-white border-2 border-top border-white">
                <center><p class="small text-muted mb-0">&copy; Copyrights. All rights reserved.</p></center>
            </div>
        </footer>
    </body>
</html>