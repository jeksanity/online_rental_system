<?php

include('../db_connect.php');

if (isset($_POST['displaySend'])) {
    $table = '<table class="table table-striped table-hover table-bordered" id="payment-table"> 
    <thead>
        <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Tenant</th>
        <th scope="col" class="text-center">Invoice</th>
        <th scope="col" class="text-center">Amount</th>
        <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>';
    $i = 1;
    $sql = "SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as fullname FROM payments p inner join tenants t on t.id = p.tenant_id where t.status = 1 order by date(p.date_created) desc";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $date = date('M d, Y', strtotime($row['date_created']));
        $name = ucwords($row['fullname']);
        $invoice = number_format($row['invoice']);
        $amount = number_format($row['amount']);
        $table .= '<tr>
        <td class="text-center">' . $i++ . '</td>
        <td class="text-center">' . $date . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center">' . $invoice . '</td>
        <td class="text-center">' . $amount . '</td>
        <td class="text-center">
        <button type="button" class="btn btn-primary" onclick="update_payment(' . $id . ')">Edit</button>
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
        $('#payment-table').DataTable();
    });
</script>