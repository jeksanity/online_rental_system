<?php

include('./db_connect.php');

extract($_POST);

if(isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['type'])) {

    $sql = "INSERT INTO users (name, username, password, type)
            VALUES ('$name', '$username', '$password', '$type')";

    $result = mysqli_query($con, $sql);
}
