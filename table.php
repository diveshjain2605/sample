<html>
<title>Registered Users</title>
<?php
include('conn.php');
$rawQuery = "SELECT * FROM user";

$records = mysqli_query($conn, $rawQuery);


?>
<style>
table {
    font-family: arial, sans-serif;
    width: 50%;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 5px;
}
</style>

<body>
    <table>
        <tr>
            <th>Id</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>user_name</th>
            <th>password</th>
        </tr>
        <tbody>

            <?php while ($row = mysqli_fetch_array($records)) {
   
 ?>
            <tr>
                <td><?php echo  $row['id'];
?></td>
                <td><?php echo  $row['first_name'];?></td>
                <td><?php echo  $row['last_name'];?></td>
                <td><?php echo  $row['email'];?></td>
                <td><?php echo  $row['user_name'];?></td>
                <td><?php echo  $row['  '];?></td>
            </tr>
            <?php }
?>
    </table>
</body>
</html>
<html>
<title>Registered Users</title>
<?php
include('conn.php');
$rawQuery = "SELECT * FROM user";

$records = mysqli_query($conn, $rawQuery);
?>
<style>
select {
    font-family: arial, sans-serif;
    width: 50%;
    padding: 10px;
    margin: 20px 0;
}
</style>

<body>
    <h3>Select a User:</h3>
    <select>
        <option value="">-- Select a User --</option>
        <?php while ($row = mysqli_fetch_array($records)) { ?>
        <option value="<?php echo $row['id']; ?>">
            <?php echo $row['first_name'] . ' ' . $row['last_name'] . ''; ?>
        </option>
        <?php } ?>
    </select>
</body>

</html>