<?php
include('../Assets/Session.php');

$strSQL = "SELECT * FROM members WHERE member_username = '".$_SESSION['member_username']."' ";
$objQuery = mysqli_query($objConnect, $strSQL);
$objResult = mysqli_fetch_array($objQuery);
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
        <section class="vh-100" style="background-color: #f4f5f7;">
            <div class="container py-5 h-50">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-lg-6 mb-4 mb-lg-0">
                        <div class="card mb-3" style="border-radius: .5rem;">
                            <div class="row g-0">
                                <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="https://locatium.ai/wp-content/uploads/2021/11/avatardefault_92824.webp"
                                    alt="Avatar" class="img-fluid my-5" style="width: 120px;" />
                                <b><p>Welcome</p></b>
                                <a style="font-size:18px"><?php echo $objResult["member_fullname"]; ?></a>
                                <i class="far fa-edit mb-5"></i>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <b><h4>INFORMATION</h4></b>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-6 mb-3">
                                                <h6>FULLNAME</h6>
                                                <p class="text-muted" style="font-size:18px"><?php echo $objResult["member_fullname"]; ?></p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>CONTACT</h6>
                                                <p class="text-muted" style="font-size:18px"><?php echo $objResult["member_contact"]; ?></p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>ADDRESS</h6>
                                                <p class="text-muted" style="font-size:18px"><?php echo $objResult["member_address"]; ?></p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>EMAIL</h6>
                                                <p class="text-muted" style="font-size:18px"><?php echo $objResult["member_email"]; ?></p>
                                            </div>
                                        </div>

                                        <h4>YOUR ACCOUNT</h4>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-6 mb-3">
                                                <h6>Username</h6>
                                                <p class="text-muted" style="font-size:18px"><?php echo $objResult["member_username"]; ?></p>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <h6>Password</h6>
                                                <p class="text-muted" style="font-size:18px"><?php echo $objResult["member_password"]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-editAccount" data-bs-toggle="modal" data-bs-target="#edit-account">EDIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal EditAccount -->
        <div class="modal fade" id="edit-account" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">EDIT ACCOUNT</h3>
                        </div>
                        <form name="formLogin"  method="post" action="EditAccount.php">
                            <input type="hidden" name="member_id" id="member_id" class="form-control form-input" value="<?=$objResult['member_id'];?>">
                            <div class="form-group">
                                <a>Fullname</a>
                                <input type="text" name="member_fullname" id="member_fullname" class="form-control form-input" value="<?=$objResult['member_fullname'];?>">
                            </div>
                            <div class="form-group">
                                <a>Contact</a>
                                <input type="text" name="member_contact" id="member_contact" class="form-control form-input" value="<?=$objResult['member_contact'];?>">
                            </div>
                            <div class="form-group">
                                <a>Address</a>
                                <input type="text" name="member_address" id="member_address" class="form-control form-input" value="<?=$objResult['member_address'];?>">
                            </div>
                            <div class="form-group">
                                <a>Email</a>
                                <input type="text" name="member_email" id="member_email" class="form-control form-input" value="<?=$objResult['member_email'];?>">
                            </div>
                            <div class="form-group">
                                <a>Username</a>
                                <input type="text" name="member_username" id="member_username" class="form-control form-input" value="<?=$objResult['member_username'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <a>Password</a>
                                <input type="text" name="member_password" id="member_password" class="form-control form-input" value="<?=$objResult['member_password'];?>">
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn">CONFIRM</button>
                                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </form>
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