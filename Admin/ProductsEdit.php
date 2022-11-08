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
        <title>ADMIN PANEL</title>
        <link rel="stylesheet" href="../css/styles-admin.css">
    </head>

    <body>
        <!-- Navbar  -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
            <div class="container">
                <img src="../img/logo.png" class="imgLogo">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav navbar-margin">
                        <li class="navbar-item">
                            <a class="nav-link text-white" href="#">ADMIN PANEL</a>
                        </li>
                    </ul>
                </div>
                <?php if(isset($_SESSION['member_username'])): ?>
                <div>
                    <li class="dropdown btn-logout-position">
                        <a class="nav-link dropdown-toggle btn-right" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            WELCOME - <?php echo $_SESSION['member_username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-white" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><button type="submit" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-account">ACCOUNT</a></li>
                            <li><a class="dropdown-item" href="../Assets/Logout.php">LOGOUT</a></li>
                        </ul>
                    </li>
                </div>
                <?php else: ?>
                    <?php Header("Location: ../Admin/Login.php"); ?>
                <?php endif; ?>
            </div>
        </nav>

        <?php
        $sql = "SELECT * FROM products WHERE product_id='$_GET[product_id]'";
        $result = mysqli_query($objConnect ,$sql);
        $data = mysqli_fetch_array($result, MYSQLI_BOTH)
        ?>

        <!-- Sidebar -->
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Sidebar -->
                <div class="col-1 list-group list-group-flush container-create">
                    <div class="container-create-text">
                        <a href="Home.php" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>HOME</span>
                        </a>
                        <a href="Users.php" class="list-group-item list-group-item-action py-2 ripple ">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>USERS</span>
                        </a>
                        <a href="Categories.php" class="list-group-item list-group-item-action py-2 ripple ">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>CATEGORIES</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>PRODUCTS</span>
                        </a>
                        <a href="Results.php" class="list-group-item list-group-item-action py-2 ripple">   
                            <i class="fas fa-lock fa-fw me-3"></i><span>RESULTS</span>
                        </a>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-10">
                    <div class="col-lg-8">
                        <div class="row mb-4 mt-4">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                        <div class="row card-table">
                            <div class="card" style="margin-left: 30%;">
                                <div class="card-header-main">
                                    <center><b>EDIT PRODUCT</b></center>
                                </div>
                                <div class="card-body frame-main">
                                    <form class="form-container" id="manage-product" method="post" action="ProductsEditProcess.php" enctype="multipart/form-data">
                                        <input type="hidden" name="product_id" value="<?=$data['product_id'];?>" ?>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <b><label for="" class="control-label">NAME</label></b>
                                                <input type="text" class="form-control" name="product_name"  value="<?=$data['product_name'];?>">
                                            </div>
                                            <div class="col-md-6">
                                                <b><label for="" class="control-label">CREATED BY</label></b>
                                                <input type="text" class="form-control" name="product_created_by"  value="<?=$data['product_created_by'];?>"readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div>
                                            <b><label class="control-label">CATEGORY</label></b>
                                                <select class="form-select form-create-products" name="product_category_id">
                                                    <option value=""></option>
                                                    <?php
                                                    $category = "SELECT * FROM categories ORDER BY category_name ASC";
                                                    $qry = mysqli_query($objConnect, $category);
                                                    while($row = $qry->fetch_assoc()):
                                                    ?>
                                                    <option value="<?php echo $row['category_id'] ?>" 
                                                                    <?php echo isset($product_category_id) && $product_category_id == $row['category_id'] ? 'selected' : '' ?>>
                                                                    <?php echo $row['category_name'] ?>
                                                    </option>
                                                    <?php echo $row['category_name'] ?>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <b><label for="" class="control-label">DESCRIPTION</label></b>
                                                <input type="text" class="form-control" name="product_desc" id="product_desc" value="<?=$data['product_desc'];?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <b><label class="control-label">STARTING BIDDING AMOUNT</label></b>
                                                <input type="number" name="product_start_bid" id="product_start_bid" class="form-control" value="<?=$data['product_start_bid'];?>">
                                            </div>
                                            <div class="col-md-6">
                                                <b><label class="control-label">BIDDING END DATE/TIME</label></b>
                                                <input type="datetime-local" name="product_end_bid" id="product_end_bid" class="form-control datetimepicker" value="<?=$data['product_end_bid'];?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <b><label class="control-label">PRODUCT IMAGE</label></b>
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
                </div>
            </div>
        </div>
        <!-- Main Content Area -->
        <!-- <div class="container-fluid form-align-products container-sm pt-5 pb-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-container" id="manage-product" method="post" action="ProductsEditProcess.php" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?=$data['product_id'];?>" ?>
                            <center><h4><b>EDIT PRODUCT</b></h4></center>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">NAME</label>
                                    <input type="text" class="form-control" name="product_name"  value="<?=$data['product_name'];?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">CREATED BY</label>
                                    <input type="text" class="form-control" name="product_created_by"  value="<?=$data['product_created_by'];?>"readonly>
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
        </div> -->

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