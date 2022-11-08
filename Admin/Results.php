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

        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Sidebar -->
                <div class="col-1 list-group list-group-flush container-create">
                    <div class="container-create-text">
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>HOME</span>
                    </a>
                    <a href="Users.php" class="list-group-item list-group-item-action py-2 ripple ">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>USERS</span>
                    </a>
                    <a href="Categories.php" class="list-group-item list-group-item-action py-2 ripple ">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>CATEGORIES</span>
                    </a>
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
                                    <center><b>HISTORY</b></center>
                                </div>
                                <div class="card-body frame-main">
                                    <table class="table table-condensed table-bordered table-hover tr-main">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">NAME</th>
                                                <th class="text-center">CREATE BY</th>
                                                <th class="text-center">BIDDER</th>
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
                                            $books = mysqli_query($objConnect, "SELECT b.*, m.member_fullname, p.product_created_by AS member_fullname, product_created_by, p.product_name, p.product_end_bid FROM bids b
                                                                                INNER JOIN members m ON m.member_id = b.bid_user_id 
                                                                                INNER JOIN products p ON p.product_id = b.bid_product_id
                                                                                ORDER BY b.bid_amount DESC");
                                            // echo "number of rows: " . $books->num_rows;
                                            $i = $books->num_rows;
                                            while($row = $books->fetch_assoc()):
                                                $get = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = {$row['bid_product_id']} ORDER BY bid_amount DESC LIMIT 1 ");
                                                $uid = $get->num_rows > 0 ? $get->fetch_array()['bid_user_id'] : 0 ;
                                                $bidder_id = mysqli_query($objConnect, "SELECT * FROM members WHERE member_id =  {$row['bid_user_id']} ");
                                                $bidder_data = mysqli_fetch_array($bidder_id, MYSQLI_BOTH);
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i-- ?></td>
                                                <td class="text-center">
                                                    <p ty> <?php echo ucwords($row['product_name']) ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p> <?php echo ucwords($row['product_created_by']) ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p> <?php echo ucwords($bidder_data['member_fullname']) ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p> <?php echo number_format($row['bid_amount'],2) ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $bids = $objConnect->query("SELECT bid_status, MAX(bid_amount) AS max FROM bids WHERE bid_product_id = '$row[bid_product_id]'");
                                                    $bid_data = mysqli_fetch_array($bids, MYSQLI_BOTH);
                                                    ?>
                                                    <?php if($row['bid_status'] == 1): ?>
                                                        <?php if(strtotime(date('Y-m-d H:i')) < strtotime($row['product_end_bid'])): ?>
                                                            <span class="text-dark bidding-stage">Bidding Stage</span>
                                                        <?php else: ?>
                                                        <?php if($uid == $row['bid_user_id']): ?>
                                                            <b><span class="text-dark bidding-stage-win">Wins in Bidding</span></b>
                                                        <?php else: ?>
                                                            <span class="text-dark bidding-stage-loose">Loose in Bidding</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php elseif($row['bid_status'] == 2 && $row['bid_amount'] == $bid_data['max']): ?>
                                                        <span class="text-dark bidding-stage-win">Completed</span>
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