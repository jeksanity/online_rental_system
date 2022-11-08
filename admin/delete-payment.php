<?php

include('../db_connect.php');

if (isset($_POST['deleteSend'])) {
    $unique = $_POST['deleteSend'];

    $sql = "DELETE FROM payments WHERE id = $unique";
    $result = mysqli_query($con, $sql);
}
