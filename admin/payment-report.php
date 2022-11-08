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
        <title> Payment Reports - Online Rental Management System </title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <style>
            /* #img {

        } */

            #img:hover {
                /* Animation */
                width: auto;
                height: auto;
                max-width: 200px;
                max-height: 300px;
                margin: 0 auto;
                transform: scale(1.5);
                border: 2px solid grey;
                border-radius: 20px;
                /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
            }
        </style>
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <?php include "sidebar.php"; ?>
            <!-- Page Content -->
            <div id="page-content-wrapper">

                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0">Payment Reports</h2>
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
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                                <div class="card-body">
                                    <div class="table" id="payment_reports_table">

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
                        url: "display-payment-report.php",
                        type: 'post',
                        data: {
                            displaySend: displayData
                        },
                        success: function(data, status) {
                            $('#payment_reports_table').html(data);
                        }
                    });
                }

                // Delete Payment Report
                function delete_payment_report(deleteid) {
                    $.ajax({
                        url: "delete-payment-report.php",
                        type: 'post',
                        data: {
                            deleteSend: deleteid
                        },
                        success: function(data, status) {
                            display_data();
                        }
                    });
                }
            </script>
        <?php } else {
        header("location:../admin.php");
    } ?>