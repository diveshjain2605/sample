<?php
include('conn.php');
$customer_name = mysqli_real_escape_string($conn, $_POST['customername']);
$item_name =($_POST['itemname']);
$qty = ($_POST['qty']);
$mrp = ($_POST['mrp']);
$price = ($_POST['price']);

//print_r ($_POST);
$last_id=null;
$sql = "INSERT INTO invoice (customer_name) 
    VALUES ('$customer_name')";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  }
foreach($item_name as $key=> $value){
     $sql = "INSERT INTO invoice_item (item_name, qty, mrp, total_price,invoice_id) 
    VALUES ('$item_name[$key]', '$qty[$key]', '$mrp[$key]', '$price[$key]','$last_id')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully ";
} 
else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
mysqli_close($conn);
?>