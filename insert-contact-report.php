<?php

include('../db_connect.php');

if (isset($_POST['submit'])) {
    $cname = $_POST['cname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact_reports (name, email, message)
            VALUES ('$cname', '$email', '$message')";

    $result = mysqli_query($con, $sql);

    header('location:index.php#contact-form');
    // if (move_uploaded_file($tempname, $folder)) {
    //     header('location:index.php#contact-form');
    // } else {
    //     header('location:index.php#contact-form');
    // }
}
