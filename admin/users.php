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
        <title> Users - Online Rental Management System </title>

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
                        <h2 class="fs-2 m-0">Users</h2>
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
                        <button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" onclick="show_user()">
                            Add User
                        </button>
                        <br>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                                <div class="card-header">
                                    User List
                                </div>
                                <div class="card-body">
                                    <div class="table" id="user_table">

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
                        url: "display-user.php",
                        type: 'post',
                        data: {
                            displaySend: displayData
                        },
                        success: function(data, status) {
                            $('#user_table').html(data);
                        }
                    });
                }


                //Add User
                function show_user() {
                    $('#addUserModal').modal('show');
                }

                function add_user() {
                    var name = $('#name').val();
                    var username = $('#username').val();
                    var password = $('#password').val();
                    var type = $('#type').val();

                    $.ajax({
                        url: "insert-user.php",
                        type: 'post',
                        data: {
                            name: name,
                            username: username,
                            password: password,
                            type: type
                        },
                        success: function(data, status) {
                            display_data();
                            $('#addUserModal').modal('hide');
                        }
                    });

                }

                // Delete User
                function delete_user(deleteid) {
                    $.ajax({
                        url: "delete-user.php",
                        type: 'post',
                        data: {
                            deleteSend: deleteid
                        },
                        success: function(data, status) {
                            display_data();
                        }
                    });
                }

                //Update User
                function update_user(updateid) {
                    $('#updateUserModal').modal('show');
                    $('#hiddenData').val(updateid);
                    $.post("update-user.php", {
                        updateid: updateid
                    }, function(data, status) {
                        var updateid = JSON.parse(data);
                        $('#UpdateName').val(updateid.name);
                        $('#UpdateUsername').val(updateid.username);
                        $('#UpdatePassword').val(updateid.password);
                        $('#UpdateType').val(updateid.type);
                    });

                }

                function save_user() {
                    var UpdateName = $('#UpdateName').val();
                    var UpdateUsername = $('#UpdateUsername').val();
                    var UpdatePassword = $('#UpdatePassword').val();
                    var UpdateType = $('#UpdateType').val();
                    var hiddenData = $('#hiddenData').val();

                    $.post("update-user.php", {
                            UpdateName: UpdateName,
                            UpdateUsername: UpdateUsername,
                            UpdatePassword: UpdatePassword,
                            UpdateType: UpdateType,
                            hiddenData: hiddenData
                        },
                        function(data, status) {
                            display_data();
                            $('#updateUserModal').modal('hide');
                        });
                }
            </script>
            <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModal">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="" method="post">
                                <input type="hidden" name="id">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">User Type</label>
                                    <select name="" id="type" class="form-control">
                                        <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Admin</option>
                                        <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Staff</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="add_user()">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update User Modal -->
            <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateUserModal">Update User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="" method="post">
                                <input type="hidden" id="hiddenData">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="UpdateName" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="UpdateUsername" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="UpdatePassword" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">User Type</label>
                                    <select name="" id="UpdateType" class="form-control">
                                        <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Admin</option>
                                        <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Staff</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="save_user()">Submit</button>
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