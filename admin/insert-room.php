<?php

include('../db_connect.php');

extract($_POST);

if(isset($_POST['nameSend']) && isset($_POST['rentSend']) && isset($_POST['descSend'])) {

    $sql = "INSERT INTO rooms (name, rent, description)
            VALUES ('$nameSend', '$rentSend', '$descSend')";

    $result = mysqli_query($con, $sql);
}
