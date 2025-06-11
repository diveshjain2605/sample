<?php
include('conn.php');
include('session.php');
$user_name = mysqli_real_escape_string($conn, $_POST['username']);
$password = md5(mysqli_real_escape_string($conn, $_POST['password']));
$rawQuery = "SELECT * FROM user WHERE user_name='$user_name' and password='$password'";

$query = mysqli_query($conn, $rawQuery);
// print_r($query);
// die();
if(mysqli_num_rows($query) > 0){
   
    $user = mysqli_fetch_assoc($query);
    $_SESSION['user_name'] = $user['first_name']; 
    echo "Login Success";
    header('Location: welcomepage.php');
    exit();
}else{
   echo "<script> alert('Credntional invalid');window.location.href = 'index.php';</script>";
   
}

$conn->close();
?>