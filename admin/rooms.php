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
        <title> Rooms - Online Rental Management System </title>

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
                        <h2 class="fs-2 m-0">Rooms</h2>
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
                        <button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" onclick="show_room()">
                            Add Rooms
                        </button>
                        <br>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                                <div class="card-header">
                                    Rooms List
                                </div>
                                <div class="card-body">
                                    <div class="table" id="room_table">

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
                        url: "display-room.php",
                        type: 'post',
                        data: {
                            displaySend: displayData
                        },
                        success: function(data, status) {
                            $('#room_table').html(data);
                        }
                    });
                }


                //Add Room
                function show_room() {
                    $('#addRoomModal').modal('show');
                }

                function add_room() {
                    var nameAdd = $('#roomName').val();
                    var rentAdd = $('#roomRent').val();
                    var descAdd = $('#roomDesc').val();

                    $.ajax({
                        url: "insert-room.php",
                        type: 'post',
                        data: {
                            nameSend: nameAdd,
                            rentSend: rentAdd,
                            descSend: descAdd
                        },
                        success: function(data, status) {
                            // function to display data

                        }
                    });

                }

                // Delete Room
                function delete_room(deleteid) {
                    $.ajax({
                        url: "delete-room.php",
                        type: 'post',
                        data: {
                            deleteSend: deleteid
                        },
                        success: function(data, status) {
                            display_data();
                        }
                    });
                }

                //Update Room
                function update_room(updateid) {
                    $('#hiddenData').val(updateid);
                    $.post("update-room.php", {
                        updateid: updateid
                    }, function(data, status) {
                        var updateid = JSON.parse(data);
                        $('#updateName').val(updateid.name);
                        $('#updateRent').val(updateid.rent);
                        $('#updateDesc').val(updateid.description);
                    });

                    $('#updateRoomModal').modal('show');

                }

                //Save Room
                function save_room() {
                    var updateName = $('#updateName').val();
                    var updateRent = $('#updateRent').val();
                    var updateDesc = $('#updateDesc').val();
                    var hiddenData = $('#hiddenData').val();

                    $.post("update-room.php", {
                            updateName: updateName,
                            updateRent: updateRent,
                            updateDesc: updateDesc,
                            hiddenData: hiddenData
                        },
                        function(data, status) {
                            display_data();
                            $('#updateRoomModal').modal('hide');
                        });
                }
            </script>

            <!-- Add Room Modal -->
            <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoomModal">Add Room</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="" id="room-form" method="post">
                                <input type="hidden" id="hiddenData">
                                <div class="mb-3">
                                    <label for="updateName" class="form-label"> Room Floor & No.</label>
                                    <input type="text" class="form-control" id="roomName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateRent" class="form-label">Rent</label>
                                    <input type="number" class="form-control" id="roomRent" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateDesc" class="form-label">Description</label>
                                    <textarea name="" class="form-control" id="roomDesc" rows="2" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="add_room()">Submit</button>
                            </form>
                        </div>

                        <div class="modal-footer">
                        </div>

                    </div>
                </div>
            </div>

            <!-- Update Room Modal -->
            <div class="modal fade" id="updateRoomModal" tabindex="-1" aria-labelledby="updateRoomModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateRoomModal">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="" id="room-form" method="post">
                                <input type="hidden" id="hiddenData">
                                <div class="mb-3">
                                    <label for="updateName" class="form-label"> Room Floor & No.</label>
                                    <input type="text" class="form-control" id="updateName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateRent" class="form-label">Rent</label>
                                    <input type="number" class="form-control" id="updateRent" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateDesc" class="form-label">Description</label>
                                    <textarea name="" class="form-control" id="updateDesc" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="save_room()">Submit</button>
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