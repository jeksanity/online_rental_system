<?php
session_start();
include "../db_connect.php";
if (isset($_SESSION['username']) && isset($_SESSION['id'])) {   ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="styles.css" />
        <title> Tenants - Online Rental Management System </title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <?php include "sidebar.php"; ?>
            <!-- Page Content -->
            <div id="page-content-wrapper">

                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0">Tenants</h2>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?= $_SESSION['name'] ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="users.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <!-- Button trigger modal -->
                    <div>
                        <button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" onclick="show_tenant()">
                            Add Tenant
                        </button>
                        <br>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                                <div class="card-header">
                                    Tenant List
                                </div>
                                <div class="card-body">
                                    <div class="table" id="tenant_table">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Contaienr Fluid -->
                </div><!-- End Page Content -->
            </div><!-- End Wrapper -->


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
            <script>
                var el = document.getElementById("wrapper");
                var toggleButton = document.getElementById("menu-toggle");

                toggleButton.onclick = function() {
                    el.classList.toggle("toggled");
                };

                //Display Table
                $(document).ready(function() {
                    display_data();
                });

                function display_data() {
                    var displayData = "true";

                    $.ajax({
                        url: "display-tenant.php",
                        type: 'post',
                        data: {
                            displaySend: displayData
                        },
                        success: function(data, status) {
                            $('#tenant_table').html(data);
                        }
                    });
                }

                //Add Tenant
                function show_tenant() {
                    $('#addTenantModal').modal('show');
                }

                function add_tenant() {
                    var lastname = $('#lastname').val();
                    var firstname = $('#firstname').val();
                    var middlename = $('#middlename').val();
                    var email = $('#email').val();
                    var contact = $('#contact').val();
                    var room_id = $('#room_id').val();
                    var date_in = $('#date_in').val();

                    $.ajax({
                        url: "insert-tenant.php",
                        type: 'post',
                        data: {
                            lastname: lastname,
                            firstname: firstname,
                            middlename: middlename,
                            email: email,
                            contact: contact,
                            room_id: room_id,
                            date_in: date_in
                        },
                        success: function(data, status) {
                            // function to display data
                        }
                    });

                }

                // Delete Tenant
                function delete_tenant(deleteid) {
                    $.ajax({
                        url: "delete-tenant.php",
                        type: 'post',
                        data: {
                            deleteSend: deleteid
                        },
                        success: function(data, status) {
                            display_data();
                        }
                    });
                }

                //Update Tenant
                function update_tenant(updateid) {
                    $('#updateTenantModal').modal('show');
                    $('#hiddenData').val(updateid);
                    $.post("update-tenant.php", {
                        updateid: updateid
                    }, function(data, status) {
                        var updateid = JSON.parse(data);
                        $('#hiddenData').val(updateid.id);
                        $('#UpdateLastname').val(updateid.lastname);
                        $('#UpdateFirstname').val(updateid.firstname);
                        $('#UpdateMiddlename').val(updateid.middlename);
                        $('#UpdateEmail').val(updateid.email);
                        $('#UpdateContact').val(updateid.contact);
                        $('#UpdateRoom_id').val(updateid.room_id);
                        $('#UpdateDate_in').val(updateid.date_in);
                    });

                }

                function save_tenant() {
                    var hiddenData = $('#hiddenData').val();
                    var UpdateLastname = $('#UpdateLastname').val();
                    var UpdateFirstname = $('#UpdateFirstname').val();
                    var UpdateMiddlename = $('#UpdateMiddlename').val();
                    var UpdateEmail = $('#UpdateEmail').val();
                    var UpdateContact = $('#UpdateContact').val();
                    var UpdateRoom_id = $('#UpdateRoom_id').val();
                    var UpdateDate_in = $('#UpdateDate_in').val();

                    $.post("update-tenant.php", {
                            hiddenData: hiddenData,
                            UpdateLastname: UpdateLastname,
                            UpdateFirstname: UpdateFirstname,
                            UpdateMiddlename: UpdateMiddlename,
                            UpdateEmail: UpdateEmail,
                            UpdateContact: UpdateContact,
                            UpdateRoom_id: UpdateRoom_id,
                            UpdateDate_in: UpdateDate_in
                        },
                        function(data, status) {
                            display_data();
                            $('#updateTenantModal').modal('hide');
                        });
                }
            </script>

            <!-- Add Tenant Modal -->
            <div class="modal fade" id="addTenantModal" tabindex="-1" aria-labelledby="addTenantModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTenantModal">Add Tenant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $_GET['error'] ?>
                                </div>
                            <?php } ?>
                            <form action="" id="tenant-form" method="post">
                                <input type="hidden" name="" required>
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Lastname</label>
                                    <input type="text" class="form-control" id="lastname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Firstname</label>
                                    <input type="text" class="form-control" id="firstname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="middlename" class="form-label">Middle Initial</label>
                                    <input type="text" class="form-control" id="middlename" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact #</label>
                                    <input type="text" class="form-control" id="contact" required>
                                </div>
                                <div class="mb-3">
                                    <label for="room_id" class="form-label">Room Rented</label>
                                    <select name="room_id" id="room_id" class="form-select" required>
                                        <option value=""></option>
                                        <?php
                                        $room = $con->query("SELECT * FROM rooms where id not in (SELECT room_id from tenants where status = 1) " . (isset($room_id) ? " or id = $room_id" : "") . " ");
                                        while ($row = $room->fetch_assoc()) :
                                        ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($room_id) && $room_id == $row['id'] ? 'selected' : '' ?>> <?php echo $row['name'] ?> </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date_in" class="form-label">Registration Date</label>
                                    <input type="date" class="form-control" id="date_in" value="<?php echo isset($date_in) ? date("Y-m-d", strtotime($date_in)) : '' ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="add_tenant()">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Tenant Modal -->
            <div class="modal fade" id="updateTenantModal" tabindex="-1" aria-labelledby="updateTenantModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateTenantModal">Update Tenant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="tenant-form" method="post">
                                <input type="hidden" id="hiddenData">
                                <div class="mb-3">
                                    <label for="UpdateLastname" class="form-label">Lastname</label>
                                    <input type="text" class="form-control" id="UpdateLastname">
                                </div>
                                <div class="mb-3">
                                    <label for="UpdateFirstname" class="form-label">Firstname</label>
                                    <input type="text" class="form-control" id="UpdateFirstname">
                                </div>
                                <div class="mb-3">
                                    <label for="UpdateMiddlename" class="form-label">Middle Initial</label>
                                    <input type="text" class="form-control" id="UpdateMiddlename">
                                </div>
                                <div class="mb-3">
                                    <label for="UpdateEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="UpdateEmail">
                                </div>
                                <div class="mb-3">
                                    <label for="UpdateContact" class="form-label">Contact #</label>
                                    <input type="text" class="form-control" id="UpdateContact">
                                </div>
                                <div class="mb-3">
                                    <label for="UpdateRoom_id" class="form-label">Room Rented</label>
                                    <select name="UpdateRoom_id" id="UpdateRoom_id" class="form-select" required>
                                        <option value=""></option>
                                        <?php
                                        $room = $con->query("SELECT * FROM rooms where id not in (SELECT room_id from tenants where status = 1) " . (isset($UpdateRoom_id) ? " or id = $UpdateRoom_id" : "") . " ");
                                        while ($row = $room->fetch_assoc()) :
                                        ?>
                                            <option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="UpdateDate_in" class="form-label">Registration Date</label>
                                    <input type="date" class="form-control" id="UpdateDate_in" value="<?php echo isset($UpdateDate_in) ? date("Y-m-d", strtotime($UpdateDate_in)) : '' ?>">
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="save_tenant()">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

        <?php } else {
        header("location:../admin.php");
    } ?>