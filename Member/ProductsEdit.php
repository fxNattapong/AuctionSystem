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

        <?php
        $sql = "SELECT * FROM products WHERE product_id='$_GET[product_id]'";
        $result = mysqli_query($objConnect ,$sql);
        $data = mysqli_fetch_array($result, MYSQLI_BOTH)
        ?>

        <!-- Main Content Area -->
        <div class="container-fluid form-align-products container-sm pt-5 pb-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-container" id="manage-product" method="post" action="ProductsEditProcess.php" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?=$data['product_id'];?>" ?>
                            <center><h4><b>EDIT PRODUCT</b></h4></center>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">NAME</label>
                                    <input type="text" class="form-control" name="product_name"  value="<?=$data['product_name'];?>">
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div>
                                    <label class="control-label">CATEGORY</label>
                                    <select class="form-select form-create-products" name="product_category_id">
                                        <option value=""></option>
                                        <?php
                                        $category = "SELECT * FROM categories order by category_name asc";
                                        $qry = mysqli_query($objConnect, $category);
                                        while($row = $qry->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['category_id'] ?>" 
                                                        <?php echo isset($product_category_id) && $product_category_id == $row['category_id'] ?>>
                                                        <?php echo $row['category_name'] ?>
                                        </option>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">DESCRIPTION</label>
                                    <input type="text" class="form-control" name="product_desc" id="product_desc" value="<?=$data['product_desc'];?>">
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="control-label">STARTING BIDDING AMOUNT</label>
                                    <input type="number" name="product_start_bid" id="product_start_bid" class="form-control" value="<?=$data['product_start_bid'];?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">BIDDING END DATE/TIME</label>
                                    <input type="datetime-local" name="product_end_bid" id="product_end_bid" class="form-control datetimepicker" value="<?=$data['product_end_bid'];?>">
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label class="control-label">PRODUCT IMAGE</label>
                                    <input type="file" name="product_img" id="product_img" class="form-control" onchange="displayImg(this,$(this))">
                                </div>
                                <div class="col-md-5">
                                    <img src="<?php echo $data['product_img'] ?>" alt="" id="img_path-field" class="img-formEdit">
                                </div>
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn1">SAVE</button>
                            </div>
                            <div style="margin-top: 1%">
                                <button type="button" class="btn2" onclick="window.history.back();">Cancel</button>
                            </div>
                        </form>
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