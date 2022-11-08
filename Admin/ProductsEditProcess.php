<?php
include('../Assets/db_connect.php');

$name = $_FILES['product_img']['name'];
$img_temp = $_FILES['product_img']['tmp_name'];
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["product_img"]["name"]);

// Select file type
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Valid file extensions
$extensions_arr = array("jpg","jpeg","png","gif");

// Check extension
if($img_temp != ""){
    // Upload file
    if(move_uploaded_file($_FILES['product_img']['tmp_name'], $target_dir.$name)){
       // Convert to base64 
       $image_base64 = base64_encode(file_get_contents('../uploads/'.$name) );
       $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
       // Insert record
       $sql_update="UPDATE products 
                        SET product_name = '$_POST[product_name]',
                            product_category_id ='$_POST[product_category_id]',
                            product_desc = '$_POST[product_desc]',
                            product_start_bid = '$_POST[product_start_bid]',
                            product_end_bid = '$_POST[product_end_bid]',
                            product_img = '$image'
                        WHERE product_id = '$_POST[product_id]' ";
       $result = mysqli_query($objConnect, $sql_update);
       if(!$result) {
            echo "<script>";
            echo "alert(\" CAN'T UPDATE \");"; 
            echo "window.history.back()";
            echo "</script>";
        } else {
            Header("Location: Products.php");
        }
    }
    
} else {
    $sql_update="UPDATE products 
                    SET product_name = '$_POST[product_name]',
                        product_category_id ='$_POST[product_category_id]',
                        product_desc = '$_POST[product_desc]',
                        product_start_bid = '$_POST[product_start_bid]',
                        product_end_bid = '$_POST[product_end_bid]'
                    WHERE product_id = '$_POST[product_id]' ";
    $result = mysqli_query($objConnect, $sql_update);
    if(!$result) {
        echo "<script>";
        echo "alert(\" CAN'T UPDATE \");";
        echo "window.history.back()";
        echo "</script>";
    } else {
        Header("Location: Products.php");
    }
}
?>
