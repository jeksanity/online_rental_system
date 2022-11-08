<?php

include('../db_connect.php');

if(isset($_POST['updateid'])) {
    $id = $_POST['updateid'];

    $sql = "SELECT * FROM payments WHERE id = $id";
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
        $tenant_id = $_POST['UpdateTenant_id'];
        $invoice = $_POST['UpdateInvoice'];
        $amount = $_POST['UpdateAmount'];

        $sql = "UPDATE payments SET tenant_id='$tenant_id', amount='$amount', invoice='$invoice' WHERE id = $uniqueid";
        $result = mysqli_query($con, $sql);
    }
