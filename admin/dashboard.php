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
        <title> Dashboard - Online Rental Management System </title>
    </head>

    <body>
        <div class="d-flex" id="wrapper">
            <?php include "sidebar.php"; ?>
            <!-- Page Content -->
            <div id="page-content-wrapper">

                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0">Dashboard</h2>
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

                <div class="container-fluid px-3">
                    <div class="row g-3 my-2">

                        <div class="col-md-4">
                            <div class="p-4 bg-white shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2"><span><?php echo $con->query("SELECT * FROM rooms")->num_rows ?></span></h3>
                                    <p class="fs-5">Total Rooms</p>
                                </div>
                                <i class="fas fa-solid fa-door-open fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-4 bg-white shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2"><?php echo $con->query("SELECT * FROM tenants")->num_rows ?></h3>
                                    <p class="fs-5">Total Tenants</p>
                                </div>
                                <i class="fas fa-street-view fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-4 bg-white shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <h3 class="fs-2">
                                        <?php
                                        $payment = $con->query("SELECT sum(amount) as paid FROM payments where date(date_created) = '" . date('Y-m-d') . "' ");
                                        echo $payment->num_rows > 0 ? number_format($payment->fetch_array()['paid']) : 0;
                                        ?>
                                    </h3>
                                    <p class="fs-5">Payments This Month</p>
                                </div>
                                <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                            </div>
                        </div>

                        <div class="row my-5">
                            <h3 class="fs-4 mb-3">Recent Tenants</h3>
                            <div class="col">
                                <table class="table bg-white rounded shadow-lg  table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col" width="50">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $sql = "SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as fullname, r.name,r.rent FROM tenants t inner join rooms r on r.id = t.room_id where t.status = 1 order by r.name desc";
                                        $result = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $months = abs(strtotime(date('Y-m-d') . " 23:59:59") - strtotime($row['date_in'] . " 23:59:59"));
                                            $months = floor(($months) / (30 * 60 * 60 * 24));
                                            $payable = ($row['rent'] * $months);
                                            $paid = $con->query("SELECT SUM(amount) as paid FROM payments where tenant_id =" . $row['id']);
                                            $last_payment = $con->query("SELECT * FROM payments where tenant_id =" . $row['id'] . " order by unix_timestamp(date_created) desc limit 1");
                                            $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
                                            $last_payment = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
                                            $outstanding = $paid - $payable;
                                            $id = $row['id'];
                                            $name = $row['fullname'];
                                            $room = $row['name'];
                                            $rent = number_format($row['rent']);
                                            $outstanding = number_format($outstanding = $paid - $payable);
                                        ?>
                                            <tr class="text-center">
                                                <th scope="row"><?php echo $i++; ?></th>
                                                <td><?php echo $name; ?></td>
                                                <td><?php echo $room ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div><!-- End Contaienr Fluid -->
            </div><!-- End Page Content -->
        </div><!-- End Wrapper -->


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
    </body>

    </html>
<?php } else {
    header("location:../admin.php");
} ?>