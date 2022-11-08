<?php

include('../db_connect.php');

if(isset($_POST['updateid'])) {
    $id = $_POST['updateid'];

    $sql = "SELECT * FROM rooms WHERE id = $id";
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

    //Update
    if(isset($_POST['hiddenData'])){
        $uniqueid = $_POST['hiddenData'];
        $name = $_POST['updateName'];
        $rent = $_POST['updateRent'];
        $desc = $_POST['updateDesc'];

        $sql = "UPDATE rooms SET name='$name', rent='$rent', description='$desc' WHERE id=$uniqueid";
        $result = mysqli_query($con, $sql);
    }
