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
        <title> Payments - Online Rental Management System </title>

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
                        <h2 class="fs-2 m-0">Payments</h2>
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
                        <button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 float-right" onclick="show_payment()">
                            Add Payment
                        </button>
                        <br>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                                <div class="card-header">
                                    Payment List
                                </div>
                                <div class="card-body">
                                    <div class="table" id="payment_table">

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
                        url: "display-payment.php",
                        type: 'post',
                        data: {
                            displaySend: displayData
                        },
                        success: function(data, status) {
                            $('#payment_table').html(data);
                        }
                    });
                }

                //Add Payment
                function show_payment() {
                    $('#addPaymentModal').modal('show');
                }

                function add_payment() {
                    var tenant_id = $('#tenant_id').val();
                    var invoice = $('#invoice').val();
                    var amount = $('#amount').val();

                    $.ajax({
                        url: "insert-payment.php",
                        type: 'post',
                        data: {
                            tenant_id: tenant_id,
                            invoice: invoice,
                            amount: amount
                        },
                        success: function(data, status) {
                            // function to display data
                            display_data();
                        }
                    });

                }

                // Delete Tenant
                function delete_tenant(deleteid) {
                    $.ajax({
                        url: "delete-payment.php",
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
                function update_payment(updateid) {
                    $('#updatePaymentModal').modal('show');
                    $('#hiddenData').val(updateid);
                    $.post("update-payment.php", {
                        updateid: updateid
                    }, function(data, status) {
                        var updateid = JSON.parse(data);
                        $('#UpdateTenant_id').val(updateid.tenant_id);
                        $('#UpdateInvoice').val(updateid.invoice);
                        $('#UpdateAmount').val(updateid.amount);
                    });

                }

                function save_payment() {
                    var UpdateTenant_id = $('#UpdateTenant_id').val();
                    var UpdateInvoice = $('#UpdateInvoice').val();
                    var UpdateAmount = $('#UpdateAmount').val();
                    var hiddenData = $('#hiddenData').val();

                    $.post("update-payment.php", {
                            UpdateTenant_id: UpdateTenant_id,
                            UpdateInvoice: UpdateInvoice,
                            UpdateAmount: UpdateAmount,
                            hiddenData: hiddenData
                        },
                        function(data, status) {
                            display_data();
                            $('#updatePaymentModal').modal('hide');
                        });
                }
            </script>

            <!-- Add Payment Modal -->
            <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPaymentModal">Add Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="" method="post">
                                <input type="hidden" name="id">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Tenant</label>
                                    <select name="" id="tenant_id" class="form-select" required>
                                        <option value=""></option>
                                        <?php
                                        $tenant = $con->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM tenants where status = 1 order by name asc");
                                        while ($row = $tenant->fetch_assoc()) :
                                        ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($tenant_id) && $tenant_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <!-- <div class="mb-3">
                                    <div class="form-group" id="details">

                                    </div>
                                </div> -->
                                <div class="mb-3">
                                    <label for="invoice" class="form-label">Invoice</label>
                                    <input type="number" class="form-control" id="invoice" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount Paid</label>
                                    <input type="number" class="form-control" id="amount" value="" required>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="add_payment()">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Payment Modal -->
            <div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updatePaymentModal">Update Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="" method="post">
                                <input type="hidden" id="hiddenData">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Tenant</label>
                                    <select name="" id="UpdateTenant_id" class="form-select" disabled>
                                        <option value=""></option>
                                        <?php
                                        $tenant = $con->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM tenants where status = 1 order by name asc");
                                        while ($row = $tenant->fetch_assoc()) :
                                        ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($tenant_id) && $tenant_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="invoice" class="form-label">Invoice</label>
                                    <input type="text" class="form-control" id="UpdateInvoice" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount Paid</label>
                                    <input type="text" class="form-control" id="UpdateAmount" value="" required>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="save_payment()">Submit</button>
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