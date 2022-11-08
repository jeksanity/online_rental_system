<?php
session_start();
include "db_connect.php";

if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    if (empty($username)) {
        header("location:admin.php?error=Username Is Required!");
    } else if (empty($password)) {
        header("location:admin.php?error=Password Is Required!");
    } else {

        // Hashing the password
        // $password = md5($password);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) === 1) {
            // the user name must be unique
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] === $password && $row['username'] == $username) {
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                header("location:admin/dashboard.php");
            } else {
                header("location:admin.php?error=Incorect Username or Password!");
            }
        } else {
            header("location:admin.php?error=Incorect Username or Password!");
        }
    }
} else {
    header("location:admin.php");
}
