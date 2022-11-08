<?php

include('../db_connect.php');

if (isset($_POST['displaySend'])) {
    $table = '<table class="table table-striped table-hover table-bordered" id="payment-reports-table"> 
    <thead>
        <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Name</th>
        <th scope="col" class="text-center">Unit</th>
        <th scope="col" class="text-center">MOP</th>
        <th scope="col" class="text-center">Image</th>
        <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>';
    $i = 1;
    $sql = "SELECT * FROM payment_reports ORDER BY DATE(date_created) DESC";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $unit = $row['unit'];
        $mop = $row['mop'];
        $image = $row['image'];
        $date = date('M d, Y', strtotime($row['date_created']));
        $table .= '<tr>
        <td class="text-center">' . $i++ . '</td>
        <td class="text-center">' . $date . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center">' . $unit . '</td>
        <td class="text-center">' . $mop . '</td>
        <td class="text-center"><img id="img" class="img-fluid" width="50px" height="50px" src="../image/' . $image . '" alt="..."></td>
        <td class="text-center">
        <button type="button" class="btn btn-danger" onclick="delete_payment_report(' . $id . ')">Delete</button>
        </td>
        </tr>';
    }
    $table .= '</table>';
    echo $table;
}
?>
<script>
    $(document).ready(function() {
        $('#payment-reports-table').DataTable();
    });
</script>