<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

session_start();
include "../db_connect.php";
if (isset($_SESSION['username']) && isset($_SESSION['id'])) {

    require("../PHPMailer/src/PHPMailer.php");
    require("../PHPMailer/src/SMTP.php");

    if (isset($_POST['submit'])) {

        $mailTo =  $_POST['email'];
        $name = $_POST['name'];
        $electricity = $_POST['electricity'];
        $water = $_POST['water'];
        $balance = $_POST['balance'];
        $date = $_POST['date'];
        $due = $_POST['due'];
        $body = $_POST['message'];

        $mail = new PHPMailer();
        // $mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->Host = "mail.smtp2go.com";
        $mail->SMTPAuth = true;
        $mail->Username = "catmonapartment";
        $mail->Password = "admin";
        $mail->SMTPSecure = "tls";
        $mail->Port = "2525";
        $mail->From = "santia.jerico@dfcamclp.edu.ph";
        $mail->FromName = "Catmon Admin";
        $mail->addAddress($mailTo, "Hello Tenant");
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body = " Bobby <br>
                        Catmon Apartment <br>
                        Catmon St. Doña Josefa Pillar Village, Las Piñas City <br>
                        <hr>"
            . $date .
            "<br>
                        Dear " . $name .
            ", <br> 
                        I am writing you today to inform that I have not received your rent <br> 
                        for the month of " . $due .
            " If you have already paid your rent please disregard this notice and contact me immediately. <br>
                        <hr><br>
                        Electricity Bill : " . $electricity .
            "<br>
                        Water Bill : " . $water .
            "<br>
                        Rent Balance : " . $balance .
            "<br> <hr>
            <br>" . $body .
            "<br><br>Sincerely yours, <br> Catmon Apartment Admin";
        $mail->AltBody = "This is a test email notification.";

        if (!$mail->send()) {
            echo "Mailer Error :" . $mail->ErrorInfo;
        } else {
            header('location: notifications.php?alert=Email Sent Successfully!');
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="styles.css" />
        <title> Send Notifications - Online Rental Management System </title>

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
                        <h2 class="fs-2 m-0">Send Notifications</h2>
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
                    <div class="py-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card shadow p-3 mb-5 bg-body rounded">
                                    <?php if (isset($_GET['alert'])) { ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= $_GET['alert'] ?>
                                        </div>
                                    <?php } ?>
                                    <div class="card-header">
                                        <h2>Send Notifications</h2>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="Email">Email</label>
                                                    <input type="email" name="email" class="form-control">
                                                </div>
                                                <!-- <div class="mb-3">
                                                    <label for="Email">Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div> -->
                                                <div class="mb-3">
                                                    <label for="Subject">Subject</label>
                                                    <input type="text" name="subject" class="form-control">
                                                </div>
                                                <!-- <div class="mb-3">
                                                    <label for="Subject">Name</label>
                                                    <select name="" id="tenant_id" class="form-select" required>
                                                        <option value=""></option>
                                                        <?php
                                                        $tenant = $con->query("SELECT  p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as fullname FROM payments p inner join tenants t on t.id = p.tenant_id where t.status = 1 order by date(p.date_created) desc");
                                                        while ($row = $tenant->fetch_assoc()) :
                                                        ?>
                                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($tenant_id) && $tenant_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['fullname']) ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div> -->
                                                <div class="mb-3">
                                                    <label for="Subject">Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Subject">Outstanding Balance</label>
                                                    <input type="text" name="balance" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Subject">Electricity Bill</label>
                                                    <input type="text" name="electricity" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Subject">Water Bill</label>
                                                    <input type="text" name="water" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date_in" class="form-label">Date Created</label>
                                                    <input type="date" class="form-control" name="date" value="<?php echo isset($date_in) ? date("	m ([ .\t-])* dd [,.stndrh\t ]+ y", strtotime($date_in)) : '' ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date_in" class="form-label">Due Date</label>
                                                    <input type="date" class="form-control" name="due" value="<?php echo isset($date_in) ? date("	m ([ .\t-])* dd [,.stndrh\t ]+ y", strtotime($date_in)) : '' ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" placeholder="Leave a comment here" name="message" id="floatingTextarea2" style="height: 100px" value=""></textarea>
                                                        <label for="floatingTextarea2">Message</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Page Content -->
            </div><!-- End Wrapper -->


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <?php } else {
        header("location:../admin.php");
    } ?>