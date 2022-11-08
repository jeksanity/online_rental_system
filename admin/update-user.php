<?php

include('../db_connect.php');

if(isset($_POST['updateid'])) {
    $id = $_POST['updateid'];

    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $response = array();
    while($row = mysqli_fetch_assoc($result)) {
        $response = $row;
    }
    echo json_encode($response);
    }  else {
    $response['status'] = 200;
    $response['message'] = "Data Not Found!";
    }

    if(isset($_POST['hiddenData'])){
        $uniqueid = $_POST['hiddenData'];
        $name = $_POST['UpdateName'];
        $username = $_POST['UpdateUsername'];
        $password = $_POST['UpdatePassword'];
        $type = $_POST['UpdateType'];

        $sql = "UPDATE users SET name='$name', username ='$username', password ='$password', type ='$type' WHERE id = $uniqueid";
        $result = mysqli_query($con, $sql);
    }
