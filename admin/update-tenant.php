<?php

include('../db_connect.php');

if (isset($_POST['updateid'])) {
    $id = $_POST['updateid'];

    $sql = "SELECT * FROM tenants WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $response = $row;
    }
    echo json_encode($response);
}


if (isset($_POST['hiddenData'])) {
    $uniqueid = $_POST['hiddenData'];
    $firstname = $_POST['UpdateFirstname'];
    $middlename = $_POST['UpdateMiddlename'];
    $lastname = $_POST['UpdateLastname'];
    $email = $_POST['UpdateEmail'];
    $contact = $_POST['UpdateContact'];
    $room_id = $_POST['UpdateRoom_id'];
    $date_in = $_POST['UpdateDate_in'];


    $sql = "UPDATE tenants SET firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contact='$contact', room_id='$room_id', date_in='$date_in' WHERE id = $uniqueid";
    $result = mysqli_query($con, $sql);
}
