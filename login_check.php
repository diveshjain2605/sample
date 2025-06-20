<?php
include('conn.php');
include('session.php');
$user_name = mysqli_real_escape_string($conn, $_POST['username']);
$password = md5(mysqli_real_escape_string($conn, $_POST['password']));
$remember = isset($_POST['remember']) ? true : false;

$rawQuery = "SELECT * FROM user WHERE user_name='$user_name' and password='$password'";

$query = mysqli_query($conn, $rawQuery);

if(mysqli_num_rows($query) > 0){
   
    $user = mysqli_fetch_assoc($query);
    $_SESSION['user_name'] = $user['first_name']; 
    
    // Set cookie if remember me is checked
    if($remember) {
        // Set cookies for 30 days
        setcookie("remember_user", $user_name, time() + (86400 * 30), "/");
        setcookie("remember_pass", $password, time() + (86400 * 30), "/");
    }
    
    echo "Login Success";
    header('Location: welcomepage.php');
    exit();
}else{
   echo "<script> alert('Credentials invalid');window.location.href = 'index.php';</script>";
}

$conn->close();
?>
