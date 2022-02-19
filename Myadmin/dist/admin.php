<?php
// admin adding php code start
session_start();
include 'partials/_dbconnect.php';
$alerterror = false;
$alertsuccess = false;
if (isset($_GET['addadmin'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $adminname = $_POST['adminname'];
        $adminemail = $_POST['adminemail'];
        $adminpassword = $_POST['adminpassword'];
        $adminconfirm = $_POST['confirmpassword'];
        $adminphoto = addslashes(file_get_contents($_FILES['adminphoto']['tmp_name']));

        $imagevalid = false;
        $allowed_image_extension = array("png", "jpg", "jpeg");
        $file_extension = pathinfo($_FILES["adminphoto"]["name"], PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["adminphoto"]["size"] > 1000000)) {
            $imagevalid = true;
        }


        $sql4 = "SELECT *FROM `admin` WHERE `a_email` = '$adminemail' ";
        $result4 = mysqli_query($conn, $sql4);
        $num1 = mysqli_num_rows($result4);
        if ($num1 > 0 || $imagevalid == true) {
            if ($num1 > 0) {
                $alerterror = "<br>- E-mail is already registred please try with another E-mail.";
            }
            if ($imagevalid = true) {
                $alerterror .= "<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
            }
        } else {
            if ($adminpassword == $adminconfirm) {

                $hashpassword = password_hash($adminpassword, PASSWORD_DEFAULT);
                $sql5 = "INSERT INTO `admin` (`a_photo`, `a_name`, `a_email`, `a_password`) VALUES ('$adminphoto','$adminname', '$adminemail', '$hashpassword')";
                $result5 = mysqli_query($conn, $sql5);
                header('location: admin.php');
            } else {
                $alerterror .= "<br>- Confirm password can't match please enter same password in both section ";
            }
        }
    }
}
// admin adding php code end

//admin delete php code start
if (isset($_GET['deladmin'])) {
    $code = $_GET['deladmin'];
    $deladminsql = "DELETE FROM `admin` where a_id = $code";
    $result2 = mysqli_query($conn, $deladminsql);
    header('location: admin.php');
}
//admin delete php code End


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- ---------bootstrap  ----------------  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- ---------------------------------------  -->
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<style>
</style>

<body class="sb-nav-fixed">
    <!-- including head start  -->
    <?php include 'partials/head.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    <!-- including head start  -->

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4"><i class="bi bi-table"></i> Admin Table</h1>
                <hr>
                <?php
                if ($alerterror)
                    echo '<div class="alert alert-danger alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Sorry!</strong> ' . $alerterror . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>
                <?php
                if ($alertsuccess)
                    echo '<div class="alert alert-success alert-dismissible fade show mx-2" role="alert">
                    <i class="bi bi-check-circle-fill"> </i><strong>Success!! </strong>' . $alertsuccess . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                ?>


                <!-- Admin table start  -->
                <div id="Admin">
                    <div class="card mb-4">
                        <div class="card-header" style="background-color:#f3f3f3;">
                            <i class="fas fa-table me-1"></i>
                            Admin Table
                            <?php $adminmaster =  $_SESSION['email'];
                            if($adminmaster == "nayan1@gmail.com"){
                            echo '<button type="button" style="float:right;" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#addadmin"><i class="bi bi-plus">
                            </i> Add Admin</button>';
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple1">
                                <thead>
                                    <tr class="table-dark">
                                        <th>Admin ID</th>
                                        <th>Admin Photo</th>
                                        <th>Admin Name</th>
                                        <th>Admin E-mail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Admin ID</th>
                                        <th>Admin Photo</th>
                                        <th>Admin Name</th>
                                        <th>Admin E-mail</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql3 = "SELECT *FROM `admin`";
                                    $result3 = mysqli_query($conn, $sql3);
                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                        $admin_photo = "data:image/jpg;base64," . base64_encode($row3['a_photo']);

                                        echo '<tr class="table-light" >
                                        <th scope="row">' . $row3['a_id'] . '</th>
                                        <td><img src=' . $admin_photo . ' style="height: 80px; width: 80px;"></td>
                                        <td>' . $row3['a_name'] . '</td>
                                        <td>' . $row3['a_email'] . '</td>';

                                        if($adminmaster == "nayan1@gmail.com"){
                                        echo '<td><a href="admin.php?deladmin=' . $row3['a_id'] . '" type="button" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</a></td>';
                                        }
                                        
                                        echo '</tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Admin table End  -->


            </div>
        </main>
    </div>

    <!-- modals  -->
    <div class="modal fade" id="addadmin" tabindex="-1" aria-labelledby="addadmin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addadmin">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="admin.php?addadmin" class="customer-form" enctype="multipart/form-data">
                        <input type="file" class="form-control my-1" id="adminphoto" name="adminphoto" placeholder="Enter Admin Name" required="required" />
                        <input type="text" maxlength="30" class="form-control my-1" id="adminname" name="adminname" placeholder="Enter Admin Name" required="required" />
                        <input type="email" maxlength="50" class="form-control my-1" id="adminemail" name="adminemail" placeholder="Enter Admin E-Mail" required="required" />
                        <input type="password" maxlength="30" class="form-control my-1" id="adminpassword" name="adminpassword" placeholder="Enter Password" required="required" />
                        <input type="password" maxlength="30" class="form-control my-1" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required="required" />
                        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Admin</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modals  -->


    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->
</body>

</html>