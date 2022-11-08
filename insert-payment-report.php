<?php

include('db_connect.php');

if (isset($_POST['submit'])) {
    $pname = $_POST['pname'];
    $unit = $_POST['unit'];
    $contact = $_POST['contact'];
    $mop = $_POST['mop'];
    $filename = $_FILES["file"]["name"];
    $tempname = $_FILES["file"]["tmp_name"];
    $folder = "./image/" . $filename;

    $sql = "INSERT INTO payment_reports (name, unit, contact, mop, image)
            VALUES ('$pname', '$unit', '$contact', '$mop', '$filename')";

    $result = mysqli_query($con, $sql);

    if (move_uploaded_file($tempname, $folder)) {
        header('location:index.php#payment-form');
    } else {
        header('location:index.php#payment-form');
    }
}
