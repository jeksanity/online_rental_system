<?php

include('../db_connect.php');

if (isset($_POST['displaySend'])) {
    $table = '<table class="table table-striped table-hover table-bordered" id="user-table"> 
    <thead>
        <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Name</th>
        <th scope="col" class="text-center">Username</th>
        <th scope="col" class="text-center">Type</th>
        <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>';
    $i = 1;
    $sql = "SELECT * FROM users order by name asc";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $username = $row['username'];
        $type = array("", "Admin", "Staff", "Alumnus/Alumna");
        $table .= '<tr>
        <td class="text-center">' . $i++ . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center">' . $username . '</td>
        <td class="text-center">' . $type[$row['type']] . '</td>
        <td class="text-center">
        <button type="button" class="btn btn-primary" onclick="update_user(' . $id . ')">Edit</button>
        <button type="button" class="btn btn-danger" onclick="delete_user(' . $id . ')">Delete</button>
        </td>
        </tr>';
    }
    $table .= '</table>';
    echo $table;
}
?>
<script>
    $(document).ready(function() {
        $('#user-table').DataTable();
    });
</script>