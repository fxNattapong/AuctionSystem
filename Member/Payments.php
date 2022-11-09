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
        <link rel="stylesheet" href="../css/styles.css">
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
                            <a class="nav-link text-white active" href="Payments.php">PAYMENT</a>
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

        <!-- Main Content Area -->
        <div class="col-12">
            <div class="col-lg-12">
            <div class="row mb-4 mt-4">
                <div class="col-md-12">
                            
                </div>
            </div>
            <div class="row card-table">
                 <!-- FORM Panel -->

                <!-- Table Panel -->
                <div class="col-md-10 mx-auto">
                    <div class="card" style="margin-bottom: 20%;">
                        <div class="card-header-main">
                            <center><b>AUCTION WINNING ITEMS</b></center>
                        </div>
                        <div class="card-body frame-main">
                            <table class="table table-condensed table-bordered table-hover tr-main">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">OTHER INFO</th>
                                        <th class="text-center">WINNING AMOUNT</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cat = array();
                                    $cat[] = '';
                                    $qry = mysqli_query($objConnect, "SELECT * FROM categories");
                                    while($row = $qry->fetch_assoc()){
                                        $cat[$row['category_id']] = $row['category_name'];
                                    }
                                    
                                    $session_username = "'".$_SESSION['member_username']."'";
                                    $member_id = mysqli_query($objConnect, "SELECT member_id FROM members WHERE member_username = $session_username");
                                    $member_id_data = mysqli_fetch_array($member_id, MYSQLI_BOTH);

                                    $books = mysqli_query($objConnect, "SELECT * FROM products WHERE product_buyer_id = '$member_id_data[member_id]' ORDER BY product_id ASC");
                                    // echo "number of rows: " . $books->num_rows;
                                    $i = 1;
                                    while($row = $books->fetch_assoc()):
                                        ?>
                                        <?php if(strtotime(date('Y-m-d H:i')) > strtotime($row['product_end_bid'])): ?>
                                            <tr class="td-main">
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <p> <?php echo ucwords($row['product_name']) ?></p>
                                                </td>
                                                <td>
                                                    <p>Start Price: <?php echo number_format($row['product_start_bid'],2) ?></p>
                                                    <p>End Date/Time: <?php echo date("M d,Y h:i A",strtotime($row['product_end_bid'])) ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                    $bids = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = '$row[product_id]' ORDER BY bid_amount DESC");
                                                    $bids_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                                                    ?>
                                                    <p><?php echo number_format($bids_data['bid_amount'],2) ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $payments = mysqli_query($objConnect, "SELECT * FROM payments WHERE payment_bid_id = '$bids_data[bid_id]'");
                                                    $payments_data = mysqli_fetch_array($payments, MYSQLI_BOTH);
                                                    ?>
                                                    <?php if($payments_data['payment_status'] == '1' && $payments_data['payment_img'] == '0'): ?>
                                                        <b><span class="text-dark bidding-stage-waiting">Waiting for payment</span></b>
                                                    <?php elseif($payments_data['payment_status'] == '1' && $payments_data['payment_img'] != '0'): ?>
                                                        <b><span class="text-dark bidding-stage-pending">Pending</span></b>
                                                    <?php elseif($payments_data['payment_status']  == 2): ?>
                                                        <b><span class="text-dark bidding-stage-win">Completed</span></b>
                                                    <?php else: ?>
                                                        <b><span class="text-dark bidding-stage-win">Cancelled</span></b>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if($payments_data['payment_status'] == '1' && $payments_data['payment_img'] == '0'): ?>
                                                    <td class="text-right">
                                                        <center><a class="btn btn-payment modal-payments-users" type="button" 
                                                                    data-id="<?=$bids_data['bid_id'];?>" data-amount="<?=$bids_data['bid_amount'];?>">PAYMENT</a></center>
                                                    </td>
                                                <?php elseif($payments_data['payment_status'] == '1' && $payments_data['payment_img'] != '0'): ?>
                                                    <td class="text-right">
                                                        <center><a class="btn btn-edit modal-payments-users-edit" type="button"
                                                                    data-bid="<?=$bids_data['bid_id'];?>" data-amt="<?=$bids_data['bid_amount'];?>">EDIT</a></center>
                                                    </td>
                                                <?php else: ?>
                                                    <td class="text-right">
                                                        <center><a class="btn btn-view-result modal-payments-view" type="button"
                                                                    data-bid="<?=$bids_data['bid_id'];?>" data-amt2="<?=$bids_data['bid_amount'];?>" 
                                                                    data-pcode="<?=$payments_data['payment_parcel_code'];?>">VIEW</a></center>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Table Panel -->
            </div>
        </div>

        <!-- Modal Payment -->
        <div class="modal fade" id="modal-payments-users" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">PAYMENT</h3>
                        </div>
                        <form name="formPayment" method="post" action="PaymentsUsers.php" enctype="multipart/form-data">
                            <input type="hidden" name="payment_bid_id" id="payment_bid_id" class="form-control form-input" value="" readonly>
                            <div class="form-group">
                                <b><a>Amount</a><b>
                                <input type="text" name="payment_amount" id="payment_amount" class="form-control form-input" value="" readonly>
                            </div>
                            <div class="form-group">
                                <b><a>Transfer to PromptPay: 012-345-6789</a></b>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label class="control-label">Payment Image</label>
                                    <input type="file" name="payment_img" id="payment_img" class="form-control form-input" required>
                                </div>
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

        <!-- Modal Edit Payment -->
        <div class="modal fade" id="modal-payments-users-edit" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
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
                            <h3 class="title">EDIT PAYMENT</h3>
                        </div>
                        <hr>
                        <form name="formPaymentEdit" method="post" action="PaymentsUsers.php" enctype="multipart/form-data">
                            <input type="hidden" name="payment_bid_id" id="payment_bid" class="form-control form-input" value="" readonly>
                            <div class="form-group">
                                <b><a>Amount</a><b>
                                <input type="text" name="payment_amt" id="payment_amt" class="form-control form-input" value="" readonly>
                            </div>
                            <div class="form-group">
                                <b><a>Transfer to PromptPay: 012-345-6789</a></b>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label class="control-label">Payment Image</label>
                                    <input type="file" name="payment_img" id="payment_img" class="form-control form-input" onchange="displayImg(this,$(this)">
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
                            <div class="form-group">
                                <b><a>Amount</a><b>
                                <input type="text" name="payment_amt2" id="payment_amt2" class="form-control form-input" value="" readonly>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label class="control-label">Payment Image</label>
                                </div>
                                <center><div class="col-md-5 img-payments">
                                    <img src="<?php echo $data['payment_img'] ?>" alt="" id="img_path-field">
                                </div></center>
                            </div>
                            <div class="form-group">
                                <b><a>Parcel Code</a><b>
                                <input type="text" name="payment_parcel_code" id="payment_parcel_code" class="form-control form-input" value="" readonly>
                            </div>
                            <hr>
                            <div>
                                <button type="button" class="btn-cancel" data-bs-dismiss="modal">CLOSE</button>
                                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                $('.modal-payments-users').on('click', function () {
                    $('#payment_bid_id').val($(this).data('id'));
                    $('#payment_amount').val($(this).data('amount'));
                    $('#modal-payments-users').modal('show');
                });
                $('.modal-payments-users-edit').on('click', function () {
                    $('#payment_bid').val($(this).data('bid'));
                    $('#payment_amt').val($(this).data('amt'));
                    $('#modal-payments-users-edit').modal('show');
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