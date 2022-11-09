<?php
include('../Assets/Session.php');
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
                    <li class="nav-item dropdown btn-right btn-products-position">
                        <a class="nav-link " href="Products.php" role="button">CREATE</a>
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
                    <a href="Products.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>PRODUCTS</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple active">   
                        <i class="fas fa-lock fa-fw me-3"></i><span>HISTORY</span>
                    </a>
                    </div>
                </div>

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
                                        <center><b>YOUR PRODUCTS HISTORY</b></center>
                                    </div>
                                    <div class="card-body frame-main">
                                        <table class="table table-condensed table-bordered table-hover tr-main">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="">NAME</th>
                                                    <th class="">BIDDER</th>
                                                    <th class="">AMOUNT</th>
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
                                                $books = mysqli_query($objConnect, "SELECT b.*, m.member_fullname AS member_fullname, p.product_name, p.product_end_bid FROM bids b
                                                                                    INNER JOIN members m ON m.member_id = b.bid_user_id 
                                                                                    INNER JOIN products p ON p.product_id = b.bid_product_id
                                                                                    WHERE p.product_created_by = $session_username ORDER BY b.bid_amount ASC");
                                                // echo "number of rows: " . $books->num_rows;
                                                // $i = $books->num_rows;
                                                $i = 1;
                                                while($row = $books->fetch_assoc()):
                                                    $get = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = {$row['bid_product_id']} ORDER BY bid_amount DESC LIMIT 1 ");
                                                    $uid = $get->num_rows > 0 ? $get->fetch_array()['bid_user_id'] : 0 ;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                    <td class="">
                                                        <p> <?php echo ucwords($row['product_name']) ?></p>
                                                    </td>
                                                    <td class="">
                                                        <p> <?php echo ucwords($row['member_fullname']) ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <p> <?php echo number_format($row['bid_amount'],2) ?></p>
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
                                                                    <span class="text-dark bidding-stage-win">Wins in Bidding</span>
                                                                <?php else: ?>
                                                                    <span class="text-dark bidding-stage-loose">Loose in Bidding</span>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php elseif($row['bid_status'] == 2 && $row['bid_amount'] == $bid_data['max']): ?>
                                                                <?php if($uid == $row['bid_user_id']): ?>
                                                                    <b><span class="text-dark bidding-stage-win">Wins in Bidding</span></b>
                                                                <?php else: ?>
                                                                    <b><span class="text-dark bidding-stage-loose">Loose in Bidding</span></b>
                                                                <?php endif; ?>
                                                        <?php elseif($row['bid_status'] == 3): ?>
                                                            <b><span class="text-dark bidding-stage-loose">Canceled</span></b>
                                                        <?php else: ?>
                                                            <b><span class="text-dark bidding-stage-loose">Loose in Bidding</span></b>
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
                </div>
            </div>
        </div>

        <style>
            td{
                vertical-align: middle !important;
            }
            td p{
                margin: unset
            }
            img{
                max-width:100px;
                max-height: :150px;
            }
        </style>
    </body>
</html>