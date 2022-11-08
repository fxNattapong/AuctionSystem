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
                if (window.pageYOffset > 50) {
                nav.classList.add('scrolled', 'shadow');
                } else {
                nav.classList.remove('scrolled', 'shadow');
                }
            });
        </script>

        <!-- Sidebar -->
        <div class="container-fluid h-200">
            <div class="row h-100">
                <!-- Sidebar -->
                <div class="col-1 list-group list-group-flush container-create">
                    <div class="container-create-text">
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>PRODUCTS</span>
                        </a>
                        <a href="Results.php" class="list-group-item list-group-item-action py-2 ripple">   
                            <i class="fas fa-lock fa-fw me-3"></i><span>RESULTS</span>
                        </a>
                    </div>
                </div>
                
                <!-- Card Payments-->
                <div class="container-fluid form-align-products container-sm pt-5 pb-5 container-pending">
                    <div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $bids = mysqli_query($objConnect ,"SELECT * FROM bids WHERE bid_id = '$_POST[bid_id]'");
                                $bids_data = mysqli_fetch_array($bids, MYSQLI_BOTH);

                                $payments = mysqli_query($objConnect ,"SELECT * FROM payments WHERE payment_bid_id = '$_POST[bid_id]'");
                                $payment_data = mysqli_fetch_array($payments, MYSQLI_BOTH);
                                ?>

                                <div class="container-fluid">
                                    <div class="frame-main" style="padding: 14 14;">
                                    <button type="button" class="btn-close" style="float: right;" onClick='window.location.href="Products.php"'></button>
                                    <div style="font-size: 24px;">
                                        <center><b><p>PAYMENT PENDING</p></b></center>
                                    </div>
                                    <hr>
                                    <div style="margin-left: 4%; font-size: 18px">
                                        <a style="font-weight: 800">Amount</a>
                                        <input type="text" name="payment_amount" id="payment_amount" class="form-control form-input" value="<?=$bids_data['bid_amount'];?>" readonly>
                                    </div>
                                    <br>
                                    <div style="margin-left: 4%; font-size: 18px">
                                        <a style="font-weight: 800">Payment Image</a>
                                        <center><?php $payment_img = $payment_data['payment_img']; ?>
                                        <img class="img-pending" src='<?php echo $payment_img; ?>'></center>
                                    </div>
                                    <br>

                                    <form method="post" action="PaymentsPendingProcess.php">
                                        <div style="margin-left: 4%; font-size: 18px"> 
                                            <input type="hidden" name="payment_id" id="payment_id" value="<?=$payment_data['payment_id'];?>">      
                                            <b><lable>Parcel Code</label></b>
                                            <input type="text" name="payment_parcel_code" id="payment_parcel_code" value="" class="form-control form-input" required>
                                        </div>
                                        <br><hr>
                                        <div class="col-md-12">
                                            <button type="submit" id="bid" class="btn1">CONFIRM</button>
                                        </div>
                                    </form>
                                    </div>
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
    </body>
</html>