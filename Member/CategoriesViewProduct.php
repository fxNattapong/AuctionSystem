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
                    <li class="dropdown btn-logout-position">
                        <a class="nav-link dropdown-toggle btn-right" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

        <!-- Card products-->
        <div class="container-fluid form-align-products container-sm pt-5 pb-5">
            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                <div class="card-header-main">
                    <button type="button" class="btn-close" style="float: right;" onClick='window.location.href="Categories.php"'></button>
                    <div style="font-size: 24px;">
                        <center><b><a>VIEW PRODUCT</a></b></center>
                    </div>
                </div>
                <div class="card-body frame-main">
                    <div class="row">
                        <?php
                        $product = mysqli_query($objConnect, "SELECT * FROM products WHERE product_id='$_GET[product_id]'");
                        $product_data = mysqli_fetch_array($product, MYSQLI_BOTH);

                        $product_category_id = $product_data['product_category_id'];
                        $category = mysqli_query($objConnect, "SELECT * FROM categories WHERE category_id = $product_category_id");
                        $category_data = mysqli_fetch_array($category, MYSQLI_BOTH);

                        $bids = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = '$_GET[product_id]' ORDER BY bid_amount DESC");
                        $bids_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                        ?>
                        <div class="container-fluid">
                            <div>
                                <center><?php $product_img = $product_data['product_img']; ?>
                                <img class="img-product" src='<?php echo $product_img; ?>'></center>
                            </div>
                            <br>
                            <!-- Display the countdown timer in an element -->
                            <center>
                                <b><div class="text-countdown">TIME LEFT : 
                                    <a id="<?php echo $product_data['product_id']; ?>"></a>
                                </div></b>
                            </center>
                            <script>
                                var countDownDate = new Date("<?php echo date("M d,Y h:i A",strtotime($product_data['product_end_bid'])) ?>").getTime();
                                var x = setInterval(function() {
                                    var now = new Date().getTime();
                                    var distance = countDownDate - now;
                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                    document.getElementById("<?php echo $product_data['product_id']; ?>").innerHTML = days + "d " + hours + "h "
                                    + minutes + "m " + seconds + "s ";
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("<?php echo $product_data['product_id']; ?>").innerHTML = "EXPIRED";
                                    }
                                }, 100);
                            </script>
                            <div style="margin-left: 10%; font-size: 18px">       
                                <b><p>Name: </b><large><?php echo $product_data['product_name'] ?></large></p>
                                <b><p>Category: </b><?php echo $category_data['category_name'] ?></p>
                                <b><p>Starting Amount: </b><?php echo $product_data['product_start_bid'] ?></p>
                                <b><p>Until: </b><?php echo date("m d,Y h:i A",strtotime($product_data['product_end_bid'])) ?></p>
                                <?php
                                if(mysqli_num_rows($bids) > 0){
                                    echo "<b><p>Latest Bid: </b>$bids_data[bid_amount] BATH</p>";
                                } else {
                                    echo "<b><p>Latest Bid: </b>$product_data[product_start_bid] BATH</p>";
                                }
                                ?>
                                <b><p>Description: </b><?php echo $product_data['product_desc'] ?></p>
                            </div>
                            <div class="col-md-12">
                                <button type="button" id="bid" class="btn1">BID</button>
                            </div>
                            <!-- Form Hidden -->
                            <div id="bid-frm">
                                <div class="col-md-12">
                                    <form class="form-align-products" id="manage-bid" method="get" action="BidsSave.php">
                                        <hr>
                                        <input type="hidden" name="member_username" value="<?php echo $_SESSION['member_username'] ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product_data['product_id'] ?>">
                                        <div class="form-group" style="margin-left: 10%">
                                            <b><label for="" class="control-label">BID AMOUNT</label></b>
                                            <input type="number" name="bid_amount" class="form-control text-right">
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn1">SUBMIT</button>
                                            <button type="button" class="btn2" id="cancel_bid" style="margin-top: 1%">CANCEL</button>
                                        </div>
                                    </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script>
            $('#bid').click(function(){
                $(this).hide()
                $('#bid-frm').show()
            })
            $('#cancel_bid').click(function(){
                $('#bid').show()
                $('#bid-frm').hide()
            })
        </script>
        
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