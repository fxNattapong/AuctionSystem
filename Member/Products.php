<?php
include('../Assets/Session.php');

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
                            <a class="nav-link text-white" href="../index.php">HOME</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="Categories.php">CATEGORIES</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="History.php">HISTORY</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="Payments.php">PAYMENT</a>
                        </li>
                    </ul>
                </div>
                <?php if(isset($_SESSION['member_username'])): ?>
                <div>
                    <li class="nav-item dropdown btn-products-position">
                        <a class="nav-link btn-right" href="Products.php" role="button">CREATE</a>
                    </li>
                </div>
                <div>
                    <li class="dropdown btn-logout-position btn-right">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            WELCOME - <?php echo $_SESSION['member_username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-white" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="Account.php">ACCOUNT</a></li>
                            <li><a class="dropdown-item" href="../Assets/Logout.php">LOGOUT</a></li>
                        </ul>
                    </li>
                </div>
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

        <!-- Sidebar -->
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Sidebar -->
                <div class="col-1 list-group list-group-flush container-create">
                    <div class="container-create-text">
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>PRODUCTS</span>
                        </a>
                        <a href="Results.php" class="list-group-item list-group-item-action py-2 ripple">   
                            <i class="fas fa-lock fa-fw me-3"></i><span>HISTORY</span>
                        </a>
                    </div>
                </div>
                <?php
                $expire = $objConnect->query("SELECT * FROM products WHERE unix_timestamp(product_end_bid) < ".strtotime(date("Y-m-d H:i")));
                if($expire->num_rows > 0){
                    while($row = mysqli_fetch_assoc($expire)) {
                        $bids = $objConnect->query("SELECT bid_status, MAX(bid_amount) AS max FROM bids WHERE bid_product_id = '$row[product_id]'");
                        $bid_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                        // echo "product_id = " . $row['product_id'] . " "."Expire max < 0". " | " . $bid_data['max'] . "<br>";
                        $bid_user_id = $objConnect->query("SELECT bid_id, bid_user_id, bid_amount FROM bids WHERE bid_amount = $bid_data[max]");
                        $bid_user_id_data = mysqli_fetch_array($bid_user_id, MYSQLI_BOTH);
                        $sql_update_products = "UPDATE products 
                                                SET product_buyer_id = '$bid_user_id_data[bid_user_id]'
                                                WHERE product_id = '$row[product_id]' ";
                        $result = mysqli_query($objConnect, $sql_update_products);
                        if(!$result) {
                            echo "ERROR UPDATE product_buyer_id.";
                        }
                            
                        $sql_update_bids = "UPDATE bids 
                                            SET bid_status = '2'
                                            WHERE bid_product_id = '$row[product_id]' ";
                        $result = mysqli_query($objConnect, $sql_update_bids);
                        if(!$result) {
                            echo "ERROR UPDATE bid_status.";
                        }

                        $payment = $objConnect->query("SELECT payment_bid_id FROM payments WHERE payment_bid_id = '$bid_user_id_data[bid_id]'");
                        // $payment_data = mysqli_fetch_array($payment, MYSQLI_BOTH);
                        if($payment->num_rows <= 0) {
                            $sql_insert_payments = "INSERT INTO payments(payment_bid_id) 
                                                    VALUES ('$bid_user_id_data[bid_id]')";
                            $result = mysqli_query($objConnect, $sql_insert_payments);
                            if(!$result) {
                                echo "ERROR INSERT payments.";
                            }
                        }
                    }
                }
                ?>
                <!-- Main Content Area -->
                <div class="col-10">
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
                                    <div class="card-header-main">
                                        <b>LIST YOUR PRODUCTS</b>
                                        <span><a><button type="button" class="btn btn-create create" href="#" style="float: right;">CREATE NEW</button></a></span>
                                    </div>
                                    <div class="card-body frame-main">
                                        <table class="table table-condensed table-bordered table-hover tr-main">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">IMG</th>
                                                    <th class="text-center">CATEGORY</th>
                                                    <th class="text-center">PRODUCT</th>
                                                    <th class="text-center">OTHER INFO</th>
                                                    <th class="text-center">STATUS</th>
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
                                                    $session_username = "'".$_SESSION['member_username']."'";
                                                    $products = mysqli_query($objConnect, "SELECT * FROM products
                                                                                            WHERE product_created_by = $session_username 
                                                                                            ORDER BY product_id ASC ");
                                                    while($row = $products->fetch_assoc()):
                                                        $get = mysqli_query($objConnect, "SELECT * FROM bids where bid_product_id = {$row['product_id']} order by bid_amount desc limit 1");
                                                        $bid = $get->num_rows > 0 ? $get->fetch_array()['bid_amount'] : 0 ;
                                                        $tbid = mysqli_query($objConnect, "SELECT DISTINCT(bid_user_id) FROM bids where bid_product_id = {$row['product_id']} ")->num_rows;
                                                    ?>
                                                    <tr data-id= '<?php echo $row['product_id'] ?>' class="td-main">
                                                        <td class="text-center"><?php echo $i++ ?></td>
                                                            <td>
                                                                <div class="row justify-content-center">
                                                                    <?php $product_img = $row['product_img']; ?>
                                                                    <img height="100" src='<?php echo $product_img; ?>'>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-center"><b><?php echo ucwords($cat[$row['product_category_id']]) ?></b></p>
                                                            </td>
                                                            <td>
                                                                <b><p>Name: </b><?php echo ucwords($row['product_name']) ?></p>
                                                                <b><p>Description: </b><?php echo $row['product_desc'] ?></p>
                                                            </td>
                                                            <td>
                                                            <b><p>Start Price: </b><?php echo number_format($row['product_start_bid'],2) ?></p>
                                                            <b><p>End Date/Time: </b><?php echo date("M d,Y h:i A",strtotime($row['product_end_bid'])) ?></p>
                                                            <b><p>Latest Bid: </b><a class="highest_bid"><?php echo number_format($bid,2) ?></a></p>
                                                            <b><p>Total Bids: </b><a class="total_bid"><?php echo $tbid ?> user/s</a></p>
                                                        </td>

                                                        <?php
                                                        $bids = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = '$row[product_id]' ORDER BY bid_amount DESC");
                                                        $bids_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                                                        // Status
                                                        if(mysqli_num_rows($bids) > 0) {
                                                            $payments = mysqli_query($objConnect, "SELECT * FROM payments WHERE payment_bid_id = '$bids_data[bid_id]'");
                                                            ?>
                                                            <?php if(mysqli_num_rows($payments) > 0): ?>
                                                                <?php $payments_data = mysqli_fetch_array($payments, MYSQLI_BOTH); ?>
                                                                <?php if($payments_data['payment_status'] == '1' && $payments_data['payment_img'] == '0'): ?>
                                                                    <td class="text-center">
                                                                        <div>
                                                                            <b><span class="text-dark bidding-stage-waiting">Waiting</span></b>
                                                                        </div>
                                                                    </td>
                                                                <?php elseif($payments_data['payment_status'] == '1' && $payments_data['payment_img'] != '0'): ?>
                                                                    <td class="text-center">
                                                                        <div>
                                                                            <b><span class="text-dark bidding-stage-pending">Pending</span></b>
                                                                        </div>
                                                                    </td>
                                                                <?php else: ?>
                                                                    <td class="text-center">
                                                                        <div>
                                                                            <b><span class="text-dark bidding-stage-win">Completed</span></b>
                                                                        </div>
                                                                    </td>
                                                                <?php endif; ?>
                                                                
                                                            <?php else: ?>
                                                                <td class="text-center">
                                                                    <p class="text-center bidding-stage"><b><?php echo "Bidding Stage" ?></b></p>
                                                                </td>
                                                            <?php endif; ?>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td>
                                                                <p class="text-center bidding-stage"><b><?php echo "Bidding Stage" ?></b></p>
                                                            </td>
                                                            <?php
                                                        }
                                                        ?>

                                                        <!-- Action -->
                                                        <td>
                                                            <?php 
                                                            $buyer_id = mysqli_query($objConnect, "SELECT * FROM members WHERE member_id =  {$row['product_buyer_id']} ");
                                                            $buyer_data = mysqli_fetch_array($buyer_id, MYSQLI_BOTH);
                                                            if($buyer_data != 0):
                                                            ?>
                                                                <?php if($payments_data['payment_parcel_code'] == ''): ?>
                                                                <div style="margin-top: 20%;">
                                                                    <form method="post" action="PaymentsPending.php">
                                                                        <input type="hidden" name="bid_id" id="bid_id" value="<?=$bids_data['bid_id'];?>">
                                                                        <input type="hidden" name="bid_amount" id="bid_amount" value="<?=$bids_data['bid_amount'];?>">
                                                                        <center><button type="submit" class="btn btn-code">Code</button></center>
                                                                    </form>
                                                                </div>
                                                                <?php else: ?>
                                                                    <div>
                                                                    <center><a class="btn btn-view-result modal-payments-view" type="button"
                                                                            data-bid="<?=$bids_data['bid_id'];?>" data-amt2="<?=$bids_data['bid_amount'];?>" 
                                                                            data-pcode="<?=$payments_data['payment_parcel_code'];?>">VIEW</a></center>
                                                                </div>
                                                                <?php endif; ?>    
                                                            <?php else: ?>
                                                                <?php 
                                                                $buyer_id = mysqli_query($objConnect, "SELECT * FROM members WHERE member_id = {$row['product_buyer_id']} ");
                                                                $buyer_data = mysqli_fetch_array($buyer_id, MYSQLI_BOTH);
                                                                ?>
                                                                <?php if($buyer_data == 0): ?>
                                                                    <div class="text-center">
                                                                        <?php echo "<a class='btn btn-edit' href='ProductsEdit.php?product_id=$row[product_id]'>EDIT</a>" ?>
                                                                        <form method="post" action="ProductsDelete.php" style="margin-top: 8px">
                                                                            <input type="hidden" name="product_id" value="<?=$row['product_id'];?>" ?>
                                                                            <button type="submit" class='btn-cancel' href='ProductsDelete.php?product_id=$row[product_id]'>DELETE</button>
                                                                        </form>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Edit Payment -->
                                                    <div class="modal fade" id="modal-payments-seller" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-content clearfix modal-body">
                                                                    <?php 
                                                                    $id = '<input id="payment_bid_id">';
                                                                    echo $id;
                                                                    $sql = "SELECT * FROM payments WHERE payment_bid_id = '$id'";
                                                                    $result = mysqli_query($objConnect ,$sql);
                                                                    $data = mysqli_fetch_array($result, MYSQLI_BOTH);
                                                                    echo $data['payment_bid_id'];
                                                                    ?>
                                                                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    <div>
                                                                        <h3 class="title">EDIT PAYMENT</h3>
                                                                    </div>
                                                                    <form name="formPaymentEdit" method="post" action="PaymentsUsers.php" enctype="multipart/form-data">
                                                                        <input type="hidden" id="payment_bid_id" class="form-control form-input" value="" readonly>
                                                                        <div class="form-group">
                                                                            <a class="font-weight: 800;">Amount</a>
                                                                            <input type="text" name="payment_amount" id="payment_amount" class="form-control form-input" value="" readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-5">
                                                                                <label class="control-label">Payment Image</label>
                                                                            </div>
                                                                            <center><div class="col-md-5 img-payments">
                                                                                <img src="<?php echo $data['payment_img'] ?>" alt="" id="img_path-field">
                                                                            </div></center>
                                                                        </div>
                                                                        <hr>
                                                                        <div>
                                                                            <button type="submit" class="btn">SEND</button>
                                                                            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal View Payment -->
                                                    <div class="modal fade" id="modal-payments-view" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-content clearfix modal-body">
                                                                    <?php 
                                                                    $sql = "SELECT * FROM payments ";
                                                                    $result = mysqli_query($objConnect ,$sql);
                                                                    $data = mysqli_fetch_array($result, MYSQLI_BOTH)
                                                                    ?>
                                                                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    <div>
                                                                        <h3 class="title">VIEW CODE</h3>
                                                                    </div>
                                                                    <hr>
                                                                    <input type="hidden" name="payment_bid_id" id="payment_bid" class="form-control form-input" value="" readonly>
                                                                    <div class="form-group" style="margin-left: 12%;">
                                                                        <a><b>Amount<b></a>
                                                                        <input type="text" name="payment_amt2" id="payment_amt2" class="form-control form-input" value="" readonly>
                                                                    </div>
                                                                    <div class="form-group" style="margin-left: 12%;">
                                                                        <div class="col-md-5">
                                                                            <label class="control-label">Payment Image</label>
                                                                        </div>
                                                                        <center><div class="col-md-5 img-payments">
                                                                            <img src="<?php echo $data['payment_img'] ?>" alt="" id="img_path-field">
                                                                        </div></center>
                                                                    </div>
                                                                    <div class="form-group" style="margin-left: 12%;">
                                                                        <a><b>Parcel Code<b></a>
                                                                        <input type="text" name="payment_parcel_code" id="payment_parcel_code" class="form-control form-input" value="" readonly>
                                                                    </div>
                                                                    <hr>
                                                                    <div>
                                                                        <button type="button" class="btn-cancel-view" data-bs-dismiss="modal">CLOSE</button>
                                                                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
                                                <option value="<?php echo $row['category_id'] ?>" 
                                                        <?php echo isset($category_id) && $category_id == $row['category_id'] ? 'selected' : '' ?>>
                                                        <?php echo $row['category_name'] ?>
                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label class="control-label">DESCRIPTION</label>
                                            <input type="text" name="product_desc" id="product_desc" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="control-label">STARTING BIDDING AMOUNT</label>
                                            <input type="number" name="product_start_bid" id="product_start_bid" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">BIDDING END DATE/TIME</label>
                                            <input type="datetime-local" name="product_end_bid" id="product_end_bid" class="form-control datetimepicker">
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
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script>
            function displayImg(input,_this) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img_path-field').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).ready(function () {
                $('.create').on('click', function () {
                    $('#productsCreate').modal('show');
                });
                $('.modal-payments-seller').on('click', function () {
                    var payment_bid_id = $(this).data('id');
                    $(".modal-body #payment_bid_id").val( payment_bid_id );
                    var payment_amount = $(this).data('amount');
                    $(".modal-body #payment_amount").val( payment_amount );
                    $('#modal-payments-seller').modal('show');
                });
                $('.modal-payments-view').on('click', function () {
                    $('#payment_bid').val($(this).data('bid'));
                    $('#payment_amt2').val($(this).data('amt2'));
                    $('#payment_parcel_code').val($(this).data('pcode'));
                    $('#modal-payments-view').modal('show');
                });
            });
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
    </body>
</html>