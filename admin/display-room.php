<?php

include('../db_connect.php');

if (isset($_POST['displaySend'])) {
    $table = '<table class="table table-striped table-hover table-bordered" id="room-table"> 
    <thead>
        <tr>
        <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Room Floor & Name</th>
        <th scope="col" class="text-center">Rent</th>
        <th scope="col" class="text-center">Description</th>
        <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>';
    $i = 1;
    $sql = "SELECT * FROM rooms";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $rent = $row['rent'];
        $desc = $row['description'];
        $table .= '<tr class="text-center">
        <td class="text-center">' . $i++ . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center">' . $rent . '</td>
        <td class="text-center">' . $desc . '</td>
        <td>
        <button type="button" class="btn btn-primary" onclick="update_room(' . $id . ')">Edit</button>
        <button type="button" class="btn btn-danger" onclick="delete_room(' . $id . ')">Delete</button>
        </td>
        </tr>';
    }
    $table .= '</table>';
    echo $table;
}
?>
<script>
    $(document).ready(function() {
        $('#room-table').DataTable();
    });
</script>