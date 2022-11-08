<?php

include('../db_connect.php');

extract($_POST);



if (isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['room_id']) && isset($_POST['date_in'])) {
    $lastname = $_POST['lastname'];


    $sql = "INSERT INTO tenants (lastname, firstname, middlename, email, contact, room_id, date_in)
            VALUES ('$lastname', '$firstname', '$middlename', '$email', '$contact', '$room_id','$date_in')";

    $result = mysqli_query($con, $sql);
}
