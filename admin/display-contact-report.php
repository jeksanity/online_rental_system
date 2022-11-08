<?php

include('../db_connect.php');

if (isset($_POST['displaySend'])) {
    $table = '<table class="table table-striped table-hover table-bordered" id="contact-reports-table"> 
    <thead>
        <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Name</th>
        <th scope="col" class="text-center">Email</th>
        <th scope="col" class="text-center">Message</th>
        <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>';
    $i = 1;
    $sql = "SELECT * FROM contact_reports ORDER BY DATE(date_created) DESC";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $message = $row['message'];
        $date = date('M d, Y', strtotime($row['date_created']));
        $table .= '<tr>
        <td class="text-center">' . $i++ . '</td>
        <td class="text-center">' . $date . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center">' . $email . '</td>
        <td class="text-center"><p>' . $message . '</p></td>
        <td class="text-center">
        <button type="button" class="btn btn-danger" onclick="delete_contact_report(' . $id . ')">Delete</button>
        </td>
        </tr>';
    }
    $table .= '</table>';
    echo $table;
}
?>
<script>
    $(document).ready(function() {
        $('#contact-reports-table').DataTable();
    });
</script>