<?php
include('../db_connect.php');
if (isset($_POST['displaySend'])) {
    $table = '<table class="table table-striped table-hover table-bordered" id="tenant-table">
                            <thead>
                                <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Name</th>
                                <th scope="col" class="text-center">Room Rented</th>
                                <th scope="col" class="text-center">Monthly Rate</th>
                                <th scope="col" class="text-center">Outstanding Balance</th>
                                <th scope="col" class="text-center">Last Payment</th>
                                <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>';
    $i = 1;
    $sql = "SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as fullname, r.name,r.rent FROM tenants t inner join rooms r on r.id = t.room_id where t.status = 1 order by r.name desc";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $months = abs(strtotime(date('Y-m-d') . " 23:59:59") - strtotime($row['date_in'] . " 23:59:59"));
        $months = floor(($months) / (30 * 60 * 60 * 24));
        // $payable = $row['rent'] * $months;

        $payable = $con->query("SELECT invoice as payable FROM payments where tenant_id =" . $row['id']);

        $paid = $con->query("SELECT SUM(amount) as paid FROM payments where tenant_id =" . $row['id']);
        $last_payment = $con->query("SELECT * FROM payments where tenant_id =" . $row['id'] . " order by unix_timestamp(date_created) desc limit 1");

        $payable = $payable->num_rows > 0 ? $payable->fetch_array()['payable'] : 0;

        $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
        $last_payment = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
        $outstanding = $paid - $payable;
        $id = $row['id'];
        $name = $row['fullname'];
        $room = $row['name'];
        $rent = number_format($row['rent'], 2);
        // $outstanding = number_format($outstanding = $paid - $payable, 2);
        $table .= '<tr>
                                <td class="text-center">' . $i++ . '</td>
                                <td class="text-center">' . $name . '</td>
                                <td class="text-center">' . $room . '</td>
                                <td class="text-center">' . $rent . '</td>
                                <td class="text-center">' . $outstanding . '</td>
                                <td class="text-center">' . $last_payment . '</td>
                                <td>
                                <button type="button" class="btn btn-primary" onclick="update_tenant(' . $id . ')">Edit</button>
                                <button type="button" class="btn btn-danger" onclick="delete_tenant(' . $id . ')">Delete</button>
                                </td>
                                </tr>';
    }
    $table .= '</table>';
    echo $table;
}

?>

<script>
    $(document).ready(function() {
        $('#tenant-table').DataTable();
    });
</script>