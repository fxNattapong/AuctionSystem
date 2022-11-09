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
                            <center><b>YOUR AUCTION HISTORY</b></center>
                        </div>
                        <div class="card-body frame-main">
                            <table class="table table-condensed table-bordered table-hover tr-main">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">OTHER INFO</th>
                                        <th class="text-center">AMOUNT</th>
                                        <th class="text-center">STATUS</th>
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
                                    $books = mysqli_query($objConnect, "SELECT b.*, m.member_fullname AS member_fullname, p.product_name, p.product_end_bid FROM bids b
                                                                        INNER JOIN members m ON m.member_id = b.bid_user_id 
                                                                        INNER JOIN products p ON p.product_id = b.bid_product_id
                                                                        WHERE b.bid_user_id = $member_id_data[member_id] ORDER BY p.product_id ASC");
                                    // echo "number of rows: " . $books->num_rows;
                                    $i = 1;
                                    while($row = $books->fetch_assoc()):
                                        $get = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = {$row['bid_product_id']} ORDER BY bid_amount DESC LIMIT 1 ");
                                        $uid = $get->num_rows > 0 ? $get->fetch_array()['bid_user_id'] : 0 ;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td class="">
                                            <p><?php echo ucwords($row['product_name']) ?></p>
                                        </td>
                                        <td>
                                            <?php 
                                            $products = mysqli_query($objConnect, "SELECT * FROM products WHERE product_id = $row[bid_product_id]");
                                            $products_data = mysqli_fetch_array($products, MYSQLI_BOTH);
                                            ?>
                                            <p>Start Price: </b><?php echo number_format($products_data['product_start_bid'],2) ?></p>
                                            <p>End Date/Time: </b><?php echo date("M d,Y h:i A",strtotime($products_data['product_end_bid'])) ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p><?php echo number_format($row['bid_amount'],2) ?></p>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $bids = $objConnect->query("SELECT bid_status, MAX(bid_amount) AS max FROM bids WHERE bid_product_id = '$row[bid_product_id]'");
                                            $bid_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                                            ?>
                                            <?php if($row['bid_status'] == 1): ?>
                                                <?php if(strtotime(date('Y-m-d H:i')) < strtotime($row['product_end_bid'])): ?>
                                                    <b><span class="text-dark bidding-stage">Bidding Stage</span><b>
                                                <?php else: ?>
                                                <?php if($uid == $row['bid_user_id']): ?>
                                                    <b><span class="text-dark bidding-stage-win">Wins in Bidding</span></b>
                                                <?php else: ?>
                                                    <b><span class="text-dark bidding-stage-loose">Loose in Bidding</span></b>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php elseif($row['bid_status'] == 2 && $row['bid_amount'] == $bid_data['max']): ?>
                                                <?php if($uid == $row['bid_user_id']): ?>
                                                <b ><span class="text-dark bidding-stage-win">Wins in Bidding</span></b>
                                                <?php else: ?>
                                                    <b><span class="text-dark bidding-stage-loose">Loose in Bidding</span></b>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <b><span class="text-dark bidding-stage-loose">Loosing in Bidding</span></b>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Table Panel -->
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        
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