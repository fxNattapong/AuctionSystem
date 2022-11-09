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
                            <li><button type="submit" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-edit-users">ACCOUNT</a></li>
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
                        <a href="Users.php" class="list-group-item list-group-item-action py-2 ripple active">
                            <i class="fas fa-chart-area fa-fw me-3"></i><span>USERS</span>
                        </a>
                        <a href="Categories.php" class="list-group-item list-group-item-action py-2 ripple ">
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
                            <!-- FORM Panel -->

                            <!-- Table Panel -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header-main">
                                        <b>MANAGE USERS</b>
                                        <span><a><button type="button" class="btn btn-create modal-create-users" href="#" style="float: right;">CREATE NEW</button></a></span>
                                    </div>
                                    <div class="card-body frame-main">
                                        <table class="table table-condensed table-bordered table-hover tr-main">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="">NAME</th>
                                                    <th class="">USERNAME</th>
                                                    <th class="">TYPE</th>
                                                    <th class="text-center">ACTION</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            if($query_run) {
                                                ?>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $members = mysqli_query($objConnect, "SELECT * FROM members ORDER BY member_type ASC");
                                                    while($row = $members->fetch_assoc()):
                                                        $session_username = "".$_SESSION['member_username']."";
                                                        if($row['member_username'] != $session_username):
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $i++ ?></td>
                                                        <td>
                                                            <?php echo $row['member_fullname'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['member_username'] ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if($row['member_type'] == 1) {
                                                                echo "Admin";
                                                            } else {
                                                                echo "Member";
                                                            }
                                                            ?> 
                                                        </td>
                                                        <td class="text-center">
                                                            <div>
                                                                <a class='btn btn-edit modal-edit-users' 
                                                                    data-id="<?php echo $row['member_id'] ?>" data-name="<?php echo $row['member_fullname'] ?>"
                                                                    data-contact="<?php echo $row['member_contact'] ?>" data-address="<?php echo $row['member_address'] ?>"
                                                                    data-email="<?php echo $row['member_email'] ?>" data-username="<?php echo $row['member_username'] ?>"
                                                                    data-password="<?php echo $row['member_password'] ?>" data-type="<?php echo $row['member_type'] ?>">EDIT</a>
                                                                <form method="post" action="UsersDelete.php" style="margin-top: 1%">
                                                                    <input type="hidden" name="member_id" value="<?=$row['member_id'];?>" ?>
                                                                    <button type="submit" class='btn-cancel' href='UsersEdit.php?member_id=$row[member_id]'>DELETE</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                        <?php endif; ?>
                                                    <?php endwhile; ?>
                                                </tbody>
                                                <?php
                                            
                                            } else {
                                                echo "NOT FOUND ANY PRODUCTS";
                                            }
                                            ?>
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

        <!-- Modal EditAccount -->
        <div class="modal fade" id="modal-edit-users" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">EDIT ACCOUNT</h3>
                        </div>
                        <form name="formLogin"  method="post" action="UsersEdit.php">
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
                            <div class="form-group">
                                <a>Type</a>
                                <input type="text" name="member_type" id="member_type" class="form-control form-input" value="<?=$objResult['member_type'];?>">
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

        <!-- Modal Create -->
        <div class="modal fade" id="modal-create-users" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-content clearfix modal-body">
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <h3 class="title">CREATE ACCOUNT</h3>
                        </div>
                        <form name="formLogin"  method="post" action="UsersCreate.php">
                            <div class="form-group">
                                <a>Fullname</a>
                                <input type="text" name="member_fullname" id="member_fullname" class="form-control form-input" value="" required>
                            </div>
                            <div class="form-group">
                                <a>Contact</a>
                                <input type="text" name="member_contact" id="member_contact" class="form-control form-input" value="">
                            </div>
                            <div class="form-group">
                                <a>Address</a>
                                <input type="text" name="member_address" id="member_address" class="form-control form-input" value="">
                            </div>
                            <div class="form-group">
                                <a>Email</a>
                                <input type="text" name="member_email" id="member_email" class="form-control form-input" value="">
                            </div>
                            <div class="form-group">
                                <a>Username</a>
                                <input type="text" name="member_username" id="member_username" class="form-control form-input" value="" required>
                            </div>
                            <div class="form-group">
                                <a>Password</a>
                                <input type="text" name="member_password" id="member_password" class="form-control form-input" value="" required>
                            </div>
                            <div class="form-group">
                                <a>Type</a>
                                <input type="text" name="member_type" id="member_type" class="form-control form-input" value="" placeholder="1=Admin , 2=Member" required>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.modal-create-users').on('click', function () {
                    $('#modal-create-users').modal('show');
                });
                $('.modal-edit-users').on('click', function () {
                    $('#member_id').val($(this).data('id'));
                    $('#member_fullname').val($(this).data('name'));
                    $('#member_contact').val($(this).data('contact'));
                    $('#member_address').val($(this).data('address'));
                    $('#member_email').val($(this).data('email'));
                    $('#member_username').val($(this).data('username'));
                    $('#member_password').val($(this).data('password'));
                    $('#member_type').val($(this).data('type'));
                    $('#modal-edit-users').modal('show');
                });
            });
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