<?php

include('../db_connect.php');

extract($_POST);

if(isset($_POST['tenant_id']) && isset($_POST['invoice']) && isset($_POST['amount'])) {

    $sql = "INSERT INTO payments (tenant_id, invoice, amount)
            VALUES ('$tenant_id', '$invoice', '$amount')";

    $result = mysqli_query($con, $sql);
}
