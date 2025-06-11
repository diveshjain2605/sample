<?php
include('session.php');

unset($_SESSION['user_name']);
 session_destroy();
 header('Location: index.php');
 ?>