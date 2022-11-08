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
        <?php 
        $cid = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
        ?>
        <div class="contain-fluid">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-2 mx-3 mt-3">
                        <!-- Card sidebar -->
                        <div class="card">
                            <div class="card-header-main"><b style="font-size: 20px">CATEGORIES</b></div>
                                <div class="card-body frame-main">
                                    <ul class='list-group' id='cat-list'>
                                        <li class='list-group-item' data-id='all' data-href="Categories.php?page=Categories&category_id=all">ALL</li>
                                        <?php
                                            $cat = $objConnect->query("SELECT * FROM categories ORDER BY category_name asc");
                                            while($row=$cat->fetch_assoc()):
                                                $cat_arr[$row['category_id']] = $row['category_name'];
                                        ?>
                                        <li class='list-group-item' data-id='<?php echo $row['category_name'] ?>' 
                                            data-href="CategoriesSelect.php?page=CategoriesSelect&category_id=<?php echo $row['category_id'] ?>">
                                            <?php echo ucwords($row['category_name']) ?>
                                        </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Card products-->
                        <div class="col-md-9 mx-3 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                            $where = "";
                                            if($cid > 0){
                                                $where  = " and category_id = $cid ";
                                            }
                                            $cat = $objConnect->query("SELECT * FROM products WHERE product_category_id = $cid ORDER BY product_name ASC");
                                            if($cat->num_rows <= 0){
                                                echo "<center><b><a style='color: darkorchid; font-size: 24px;'>No Available Product.</a></b></center>";
                                            } 
                                            while($row=$cat->fetch_assoc()):
                                                // echo date("Y-m-d H:i" , strtotime($row['product_end_bid'])) . " < " . strtotime(date('Y-m-d H:i'));
                                                // if(date("Y-m-d H:i:s" , strtotime($row['product_end_bid'])) < ".strtotime(date('Y-m-d H:i')).") {
                                                //     echo "EXPIRED" . "<br>";
                                                // } else {
                                                //     echo "NO EXPIRED" . "<br>";
                                                // }
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
                                                        if(mysqli_num_rows($bids) > 0){
                                                            ?><span class="badge badge-pill badge-primary current-bid-text fs-6">
                                                                <li style="margin-left: 45%">CURRENT BID : 
                                                                <?php echo $bids_data['bid_amount']." BATH" ?></li>
                                                            </span><?php
                                                        } else {
                                                            ?><span class="badge badge-pill badge-primary current-bid-text fs-6">
                                                                <li style="margin-left: 40%">CURRENT BID : 
                                                                <?php echo $row['product_start_bid']." BATH" ?></li>
                                                            </span><?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="float-right align-top d-flex">
                                                        <span class="badge badge-pill badge-warning text-black fs-6">
                                                            <li style="margin-left: 35%">
                                                            UNTIL: <?php echo date("M d,Y h:i A",strtotime($row['product_end_bid'])) ?></li>
                                                        </span>
                                                    </div>
                                                    <!-- Display the countdown timer in an element -->
                                                    <!-- <div class="badge text-black fs-6" id="<?php echo $row['product_id']; ?>"></div>
                                                    <script>
                                                        var countDownDate = new Date("<?php echo date("M d,Y h:i A",strtotime($row['product_end_bid'])) ?>").getTime();
                                                        var x = setInterval(function() {
                                                            var now = new Date().getTime();
                                                            var distance = countDownDate - now;
                                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                            document.getElementById("<?php echo $row['product_id']; ?>").innerHTML = days + "d " + hours + "h "
                                                            + minutes + "m " + seconds + "s ";
                                                            if (distance < 0) {
                                                                clearInterval(x);
                                                                document.getElementById("<?php echo $row['product_id']; ?>").innerHTML = "EXPIRED";
                                                            }
                                                        }, 100);
                                                    </script> -->
                                                    <div class="card-body prod-item">
                                                        <b><p>
                                                            <label>NAME:</label></b>
                                                            <?php echo $row['product_name'] ?>
                                                        </p>
                                                        <p><b>
                                                            <label>CATEGORY:</label></b>
                                                            <?php echo $cat_arr[$row['product_category_id']] ?>
                                                        </p><b>
                                                        <p class="truncate">
                                                            <label>DESCRIPTION:</label></b>
                                                            <?php echo $row['product_desc'] ?>
                                                        </p>
                                                        <br>
                                                        <?php echo "<a class='btn btn-view' href='CategoriesViewProduct.php?product_id=$row[product_id]'>VIEW</a>" ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
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
            $(document).ready(function () {
                $('#cat-list li').click(function(){
                    location.href = $(this).attr('data-href')
                });
                $('#cat-list li').each(function(){
                    var id = '<?php echo $cid > 0 ? $cid : 'all' ?>';
                    if(id == $(this).attr('data-id')){
                        $(this).addClass('active')
                    }
                });
            });
        </script>

        <style>
            #cat-list li{
                cursor: pointer;
            }
            #cat-list li:hover {
                color: white;
                background: #007bff8f;
            }
            .prod-item p{
                margin: unset;
                margin-left: 8%;
            }
            .bid-tag {
                position: absolute;
                right: .5em;
            }
            .current-bid{
                background-color: #33a3ff;
            }
            .current-bid-text{
                color: white;
            }
            .card{
                margin-bottom: 14px;
            }
        </style>
        
         <!-- FOOTER -->
        <footer class="w-100 py-4 flex-shrink-0" style="margin-top: 10%;">
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