<?php
include('conn.php');
echo $_POST['fname']."<br>";
echo $_POST['lname']."<br>";
echo $_POST['email']."<br>";
echo $_POST['username']."<br>";
echo $_POST['password']."<br>";
echo $_POST['password']."<br>";
$first_name = mysqli_real_escape_string($conn, $_POST['fname']);
$last_name = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$user_name = mysqli_real_escape_string($conn, $_POST['username']);
echo $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

$query = mysqli_query($conn, "SELECT id FROM user WHERE user_name='$user_name'");

// if(mysqli_num_rows($query) > 0){

//     echo "Username already exists";
// }else{
//     // do something
//     if (!mysqli_query($conn,$query))
//     {
//         die('Error: ' . mysqli_error($conn));
//     }
// }
// Insert data into the database using proper SQL query
$sql = "INSERT INTO user (first_name,last_name, email, password, user_name) 
        VALUES ('$first_name','$last_name', '$email', '$password','$user_name')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header('Location: index.php');
    exit();
    // echo "<script>alert('ERror')</script>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>