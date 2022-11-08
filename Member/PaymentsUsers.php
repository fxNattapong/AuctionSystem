<?php
include('../Assets/db_connect.php');

$name = $_FILES['payment_img']['name'];
$target_dir = "../payments/";
$target_file = $target_dir . basename($_FILES["payment_img"]["name"]);

// Select file type
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Valid file extensions
$extensions_arr = array("jpg","jpeg","png","gif");

// Check extension
if( in_array($imageFileType,$extensions_arr) ){
    // Upload file
    if(move_uploaded_file($_FILES['payment_img']['tmp_name'],$target_dir.$name)){
        // Convert to base64 
        $image_base64 = base64_encode(file_get_contents('../payments/'.$name) );
        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

        $sql_update = "UPDATE payments 
                        SET payment_img = '$image'
                        WHERE payment_bid_id = '$_POST[payment_bid_id]' ";
       $result = mysqli_query($objConnect,$sql_update);
       if(!$result) {
            echo "<script>";
            echo "alert(\" ERROR CAN'T UPDATE \");"; 
            echo "window.history.back()";
            echo "</script>";
        } else {
            Header("Location: Payments.php");
        }
    }
}
?>