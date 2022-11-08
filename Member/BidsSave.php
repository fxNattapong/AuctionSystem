<?php
include('../Assets/Session.php');

$member = mysqli_query($objConnect, "SELECT * FROM members WHERE member_username = '$_GET[member_username]'");
$member_data = mysqli_fetch_array($member, MYSQLI_BOTH);

$product = mysqli_query($objConnect, "SELECT * FROM products WHERE product_id = '$_GET[product_id]'");
$product_data = mysqli_fetch_array($product, MYSQLI_BOTH);

$bids = mysqli_query($objConnect, "SELECT * FROM bids WHERE bid_product_id = '$_GET[product_id]' ORDER BY bid_amount DESC");
$bids_data = mysqli_fetch_array($bids, MYSQLI_BOTH);

if($product_data['product_created_by'] == $_GET['member_username']) {
    echo "<script>";
    echo "alert(\" Can't bid this is your product. \");"; 
    echo "window.history.back()";
    echo "</script>";
} else {
    if(mysqli_num_rows($bids) <= 0) {
        echo "DATA IN TABLE: ", mysqli_num_rows($bids);
        if($_GET['bid_amount'] < $product_data['product_start_bid']) {
            echo "<script>";
            echo "alert(\" Bid amount must be greater than the current Highest Bid. \");"; 
            echo "window.history.back()";
            echo "</script>";
        } else {
            $sql_insert = "INSERT INTO bids(bid_user_id, bid_product_id, bid_amount) 
                                VALUES ('$member_data[member_id]','$_GET[product_id]','$_GET[bid_amount]')";
            $result = mysqli_query($objConnect, $sql_insert);
            if(!$result) {
                echo "<script>";
                echo "alert(\" CAN'T BID. \");"; 
                echo "window.history.back()";
                echo "</script>";
            } else {
                // Header("Location: ViewProduct.php");
                echo "<script>";
                echo "window.history.back()";
                echo "</script>";
            }
        }
    } else {
        echo "DATA IN TABLE: ", mysqli_num_rows($bids);
        if($member_data['member_id'] == $bids_data['bid_user_id']) {
            echo "<script>";
            echo "alert(\" The current lastest bid is yours. \");"; 
            echo "window.history.back()";
            echo "</script>";
        } else {
            if(mysqli_num_rows($bids) > 0){
                if($_GET['bid_amount'] < $bids_data['bid_amount']){
                    // alert_toast("Bid amount must be greater than the current Highest Bid.",'danger')
                    echo "<script>";
                    echo "alert(\" Bid amount must be greater than the current Highest Bid. \");"; 
                    echo "window.history.back()";
                    echo "</script>";
                } else {
                    $sql_insert = "INSERT INTO bids(bid_user_id, bid_product_id, bid_amount) 
                                    VALUES ('$member_data[member_id]','$_GET[product_id]','$_GET[bid_amount]')";
                    $result = mysqli_query($objConnect, $sql_insert);
                    if(!$result) {
                        echo "<script>";
                        echo "alert(\" CAN'T BID. \");"; 
                        echo "window.history.back()";
                        echo "</script>";
                    } else {
                        echo "<script>";
                        echo "window.history.back()";
                        echo "</script>";
                    }
                }
            } else {
                $sql_insert = "INSERT INTO bids(bid_user_id, bid_product_id, bid_amount) 
                                VALUES ('$member_data[member_id]','$_GET[product_id]','$_GET[bid_amount]')";
                $result = mysqli_query($objConnect, $sql_insert);
                if(!$result) {
                    echo "<script>";
                    echo "alert(\" CAN'T BID. \");"; 
                    echo "window.history.back()";
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo "window.history.back()";
                    echo "</script>";
                }
            }
        }
    }
}
?>