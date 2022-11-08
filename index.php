<?php
session_start();
include('Assets/db_connect.php');
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <title>CENTER AUCTION SYSTEM</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body>
        <!-- Navbar  -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
            <div class="container">
                <img src="img/logo.png" class="imgLogo">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav navbar-margin">
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="#">HOME</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="Member/Categories.php">CATEGORIES</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="Member/History.php">HISTORY</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="Member/Payments.php">PAYMENT</a>
                        </li>
                    </ul>
                </div>
                <?php if(isset($_SESSION['member_username'])): ?>
                <div>
                    <li class="nav-item dropdown btn-products-position">
                        <a class="nav-link btn-right" href="Member/Products.php" role="button">CREATE</a>
                    </li>
                </div>
                <div>
                    <li class="dropdown btn-logout-position btn-right">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            WELCOME - <?php echo $_SESSION['member_username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-white" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="Member/Account.php">ACCOUNT</a></li>
                            <li><a class="dropdown-item" href="Assets/Logout.php">LOGOUT</a></li>
                        </ul>
                    </li>
                </div>
                <?php else: ?>
                    <button type="button" class="btn mx-auto show-modal" data-bs-toggle="modal" data-bs-target="#sign-in">LOGIN</button>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Modal Login -->
        <div class="modal fade" id="sign-in" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">SIGN IN</h3>
                        </div>
                        <form name="formLogin"  method="post" action="Member/MembersLogin.php">
                            <div class="form-group">
                                <a>Your username</a>
                                <input type="text" name="member_username" id="member_username" class="form-control form-input" placeholder="">
                            </div>
                            <div class="form-group">
                                <a>Your password</a>
                                <input type="password" name="member_password" id="member_password" class="form-control form-input" placeholder="">
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn">LOGIN</button>
                            </div>
                            <br>
                            <div>
                                <p>Not a member? 
                                <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#sign-up">CREATE NEW</button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Register -->
        <div class="modal fadee" id="sign-up" role="tabpanel" aria-labelledby="register">
           <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-content clearfix modal-body">
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div>
                        <h3 class="title">SIGN UP</h3>
                    </div>
                    <form name="formRegister"  method="post" action="Member/MembersRegister.php">
                        <div class="form-group">
                            <a>Fullname</a>
                            <input type="text" name="member_fullname" id="member_fullname" class="form-control form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <a>Contact</a>
                            <input type="text" name="member_contact" id="member_contact" class="form-control form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <a>Address</a>
                            <input type="text" name="member_address" id="member_address" class="form-control form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <a>Email</a>
                            <input type="email" name="member_email" id="member_email" class="form-control form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <a>Username</a>
                            <input type="text" name="member_username" id="member_username" class="form-control form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <a>Password</a>
                            <input type="password" name="member_password" id="member_password" class="form-control form-input" placeholder="">
                        </div>
                        <hr>
                        <div>
                            <button type="submit" name="register" class="btn">REGISTER</button>
                        </div>
                        <br>
                        <div>
                            <p>Already a member? 
                            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#sign-in">LOGIN HERE</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Banner Image  -->
        <div class="bg-image">
            <div class="bg-text">
                <h1 class="text-banner">Join Our Next Auction!</h1>
                <h1 class="text-banner">Find Your Equipment</h1>

                <div class="input-group">
                    <div class="form-outline">
                        <input type="text" class="form-control" placeholder="SEARCH..." aria-label="SEARCH" aria-describedby="button-addon2">
                    </div>
                    <button type="button" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
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
        <div class="container" style="margin-bottom: 3%; margin-top: 3%;">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="card-header-main " style="width: 97%">
                            <a>AUCTION ITEMS</a>
                            <span><a type="button" class="btn btn-see" href="Member/Categories.php" style="float: right;">SEE ALL</a></span>
                        </div>
                        <?php
                            $cat = $objConnect->query("SELECT * FROM products WHERE unix_timestamp(product_end_bid) >= ".strtotime(date("Y-m-d H:i"))." ORDER BY product_name asc");
                            if($cat->num_rows <= 0){
                                echo "<center><h4><i>No Available Product.</i></h4></center>";
                            } 
                            while($row=$cat->fetch_assoc()):
                        ?>
                        <div class="col-sm-4">
                            <div class="card frame-main">
                                <div class="text-center">
                                    <?php $product_img = $row['product_img']; ?>
                                    <img width="auto" height="210" src='<?php echo $product_img; ?>'>
                                </div>
                                <div class="current-bid">
                                    <?php
                                    $bids = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = '$row[product_id]' ORDER BY bid_amount DESC");
                                    $bids_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                                    ?><span class="badge badge-pill badge-primary current-bid-text fs-6">
                                    <li style="margin-left: 50%">START BID : <?php echo $row['product_start_bid']." BATH" ?></li></span>
                                    <?php
                                    ?>
                                </div>
                                <div class="float-right align-top d-flex">
                                    <span class="badge badge-pill badge-warning text-black fs-6">
                                    <li style="margin-left: 30%">UNTIL: <?php echo date("M d,Y h:i A",strtotime($row['product_end_bid'])) ?></li></span>
                                </div>
                                <div class="card-body prod-item text-center" style="font-size: 16px">
                                    <b><label>NAME:</label></b>
                                    <?php echo $row['product_name'] ?>
                                    <br><br>
                                    <?php echo "<a class='btn btn-view' href='Member/CategoriesViewProduct.php?product_id=$row[product_id]'>VIEW</a>" ?>
                                </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

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