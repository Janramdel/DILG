<?php
require_once("includes/initialize.php");

if (logged_in()) {
    if ($_SESSION['userlvl'] == 'Administrator') {
        header("location: admin/index.php");
        exit();
    } else {
        header("location: faculty/index.php");
        exit();
    }
}

if (isset($_POST['btnlogin'])) {
    $user = $mydb->escape_value(trim($_POST['uname']));
    $entered_pass = trim($_POST['pass']);

    $query = "SELECT ACCOUNT_USER, ACCOUNT_NAME, ACCOUNT_TYPE, ACCOUNT_PASSWORD FROM tbl_useraccount WHERE ACCOUNT_USER = '{$user}' LIMIT 1";
    $mydb->setQuery($query);
    $result = $mydb->executeQuery();

    if ($mydb->num_rows($result) == 1) {
        $user = $mydb->fetch_array($result);
        if (password_verify($entered_pass, $user['ACCOUNT_PASSWORD'])) {
            $_SESSION['ACCOUNT_NAME'] = $user['ACCOUNT_NAME'];
            $_SESSION['ACCOUNT_USER'] = $user['ACCOUNT_USER'];
            $_SESSION['ACCOUNT_TYPE'] = $user['ACCOUNT_TYPE'];

            if ($_SESSION['ACCOUNT_TYPE'] == "Administrator") {
                header("Location: admin/index.php");
            } elseif ($_SESSION['ACCOUNT_TYPE'] == "Faculty") {
                header("Location: faculty/index.php");
            } else {
                header("Location: student/index.php");
            }
            exit();
        } else {
            $alert_message = "Invalid ID Number or Password!";
        }
    } else {
        $alert_message = "Invalid ID Number or Password!";
    }

    echo "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                $('#alertModalBody').text('$alert_message');
                $('#alertModal').modal('show');
            });
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>L&D Management System</title>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style2.css">
        <link rel="stylesheet" href="bootstrap.min.css">
    </head>
    <body>
        <header class="site-navbar site-navbar-target" style="background-color: #1d3c60; color: #333;">
            <div style="display: flex; align-items: center;">
                <div style="display: flex; align-items: center;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Department_of_the_Interior_and_Local_Government_%28DILG%29_Seal_-_Logo.svg/2048px-Department_of_the_Interior_and_Local_Government_%28DILG%29_Seal_-_Logo.svg.png" style="width: 70px; height: 70px; margin-left: 20px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Bagong_Pilipinas_logo.png" style="width: 70px; height: 70px;">
                    <img src="https://library.region1.dilg.gov.ph/img/lgrrc1_logo.png" style="width: 50px; height: 70px; margin-left: 5px;">
                </div>
                <div style="margin-left: 20px;">
                    <p style="margin: 0; padding: 0; color: white;">Republic of the Philippines</p>
                    <h4 style="margin: 0; padding: 0; color: white;">DEPARTMENT OF INTERIOR AND LOCAL GOVERNMENT</h4>
                    <h5 style="margin: 0; padding: 0; color: white;">Regional Office I</h5>
                </div>
            </div>
        </header>

        <div class="ftco-cover-1 overlay" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/e6/City_of_San_Fernando.jpg'); background-color: rgba(0, 0, 0, 0.5);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <h1 style="color: white;">Learning and Development Management System with Feedback Mechanism</h1>
                    </div>

                    <div class="col-lg-5 ml-auto">
                        <div class="container" style="margin-top: 200px;">
                            <div class="col-md-20">
                                <div class="quick-contact-form bg-white">
                                    <h2>Login to you Account</h2>
                                    <form action="login.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="uname" maxlength="8" placeholder="ID Number">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="pass" placeholder="Password">
                                        </div> 
                                        <div class="form-group">
                                            <input type="submit" value="Login" name="btnlogin" class="btn px-5" style="background-color: #1d3c60; color: white;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal HTML -->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Login Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="alertModalBody">
                <!-- Alert message goes here -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Bootstrap JavaScript and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
