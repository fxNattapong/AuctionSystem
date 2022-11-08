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
                            <a class="nav-link text-white" href="#">CENTER AUCTION SYSTEM</a>
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
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>CATEGORIES</span>
                        </a>
                        <a href="Products.php" class="list-group-item list-group-item-action py-2 ripple">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>PRODUCTS</span>
                        </a>
                        <a href="Results.php" class="list-group-item list-group-item-action py-2 ripple">   
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
                            <!-- Form Create -->
                            <div class="col-md-3 frame-add" style="margin-left: 13px; margin-top: 1px">
                                <div class="card-header-main">
                                    <center><b>CATEGORY FORM</b></center>
                                </div>
                                <div class="frame-category">
                                    <form method="post" action="CategoriesCreate.php">
                                        <label><b>Name</label></b><br>
                                        <input type="text" name="category_name" class="form-control">
                                        <br>
                                        <center><input type="submit" class="btn-add" value="ADD">
                                        <input type="reset" class="btn-cancel" value="CANCEL"><br></center>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Form Edit/Delete -->
                            <div class="col-md-7" style="margin-left: 1%;">
                                <div class="card">
                                    <div class="card-header-main">
                                        <center><b>CATEGORY LIST</b></center>
                                    </div>
                                    <div class="card-body frame-main">
                                        <table class="table table-bordered table-hover tr-main">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i = 1;
                                                $category = $objConnect->query("SELECT * FROM categories order by category_id asc");
                                                while($row=$category->fetch_assoc()):
                                                ?>
                                                <tr>
                                                    <td class="text-center"><br><br><?php echo $i++ ?></td>
                                                    <td class="">
                                                        <br><br>
                                                        <p class="text-center"><?php echo $row['category_name'] ?></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <form method="get" action="edit.php" style="margin-top: 3%">
                                                            <input type="hidden" name="category_id" value="<?=$row['category_id'];?>" ?>
                                                            <button type="button" class="btn-edit edit-category" 
                                                                    data-id="<?=$row['category_id'];?>" data-name="<?=$row['category_name'];?>">EDIT</button>
                                                        </form>
                                                        <form method="get" action="CategoriesDelete.php" style="margin-top: 1%">
                                                            <input type="hidden" name="category_id" value="<?=$row['category_id'];?>" ?>
                                                            <button type="submit" class='btn-cancel' href='CategoriesDelete.php?category_id=$row[category_id]'>DELETE</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Edit Category -->
        <div class="modal fade" id="edit-category" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">EDIT CATEGORY</h3>
                        </div>
                        <br>
                        <form name="formLogin"  method="post" action="CategoriesEdit.php">
                            <input type="hidden" name="category_id" id="category_id" class="form-control form-input">
                            <div class="form-group">
                                <a>Category Name</a>
                                <input type="text" name="category_name" id="category_name" value="" class="form-control form-input">
                            </div>
                            <br><hr>
                                <button type="submit" class="btn">SAVE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal EditAccount -->
        <div class="modal fade" id="edit-account" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">EDIT ACCOUNT</h3>
                        </div>
                        <form name="formLogin"  method="post" action="../Member/EditAccount.php">
                            <input type="hidden" name="member_id" id="member_id" class="form-control form-input" value="<?=$objResult['member_id'];?>">
                            <input type="hidden" name="member_type" id="member_type" class="form-control form-input" value="<?=$objResult['member_type'];?>">
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script>
        $(document).ready(function () {
                $('.edit-category').on('click', function () {
                    $('#category_id').val($(this).data('id'));
                    $('#category_name').val($(this).data('name'));
                    $('#edit-category').modal('show');
                });
            });
    </script>
</html>