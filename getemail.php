<?php
header('Content-Type: application/json');
include('conn.php');
 $id = $_POST['id'] ?? ''; 
$sql = "SELECT * FROM invoice_item WHERE id='" . mysqli_real_escape_string($conn, $id) . "'";
$result = mysqli_query($conn, $sql);
if ($result)
 {
    $row = mysqli_fetch_assoc($result); 
    $email = $row['email'] ?? ''; 
    echo json_encode(['success' => true, 'received_id' => $result]); 
}
 else 
 {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]); 
}
mysqli_close($conn);
?>