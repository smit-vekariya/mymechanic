<?php
// admin adding php code start
session_start();

include 'partials/_dbconnect.php';
$alerterror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminname = $_POST['adminname'];
    $adminemail = $_POST['adminemail'];
    $adminpassword = $_POST['adminpassword'];
    $adminconfirm = $_POST['confirmpassword'];


    $sql4 = "SELECT *FROM `admin` WHERE `a_email` = '$adminemail' ";
    $result4 = mysqli_query($conn, $sql4);
    $num1 = mysqli_num_rows($result4);
    if ($num1 > 0) {
        $alerterror = "E-mail is already registred please try with another E-mail.";
    } else {
        if ($adminpassword == $adminconfirm) {

            $hashpassword = password_hash($adminpassword, PASSWORD_DEFAULT);
            $sql5 = "INSERT INTO `admin` (`a_name`, `a_email`, `a_password`) VALUES ('$adminname', '$adminemail', '$hashpassword')";
            $result5 = mysqli_query($conn, $sql5);
            header('location: usertables.php');
        } else {
            $alerterror = "Confirm password can't match please enter same password in both section ";
        }
    }
}
// admin adding php code end

//admin delete php code start
if (isset($_GET['deladmin'])) {
    $code = $_GET['deladmin'];
    $deladminsql = "DELETE FROM `admin` where a_id = $code";
    $result2 = mysqli_query($conn, $deladminsql);
    header('location: usertables.php');
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
                <h1 class="mt-4"><i class="bi bi-table"></i> Garage Owner Table</h1>
                <hr>
                <?php
                if ($alerterror)
                    echo '<div class="alert alert-danger alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Sorry!</strong> ' . $alerterror . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>


                <!-- Garages table start  -->
                <div id="Garages">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Garage Owner Table
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple3">
                                <thead>
                                    <tr class="table-dark">
                                        <th>Garage ID</th>
                                        <th>Garage Owner Photo</th>
                                        <th>Name</th>
                                        <th>Garage Name</th>
                                        <th>address</th>
                                        <th>Zipcode</th>
                                        <th>City</th>
                                        <th>Email</th>
                                        <th>Phone no.</th>
                                        <th>Licence no.</th>
                                        <th>Reg. Date</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Garage ID</th>
                                        <th>Garage Owner Photo</th>
                                        <th>Name</th>
                                        <th>Garage Name</th>
                                        <th>address</th>
                                        <th>Zipcode</th>
                                        <th>City</th>
                                        <th>Email</th>
                                        <th>Phone no.</th>
                                        <th>Licence no.</th>
                                        <th>Reg. Date</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql2 = "SELECT *FROM `garage_owner`";
                                    $result2 = mysqli_query($conn, $sql2);
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $ownerphoto = "data:image/jpg;base64," . base64_encode($row2['g_photo']);

                                        echo '<tr class="table-light">                                   
                                    <th scope="row">' . $row2['g_id'] . '</th>
                                    <th scope="row"><img src=' . $ownerphoto . ' style="height: 80px; width: 80px;"></th>
                                    <td>' . $row2['g_owner_name'] . '</td>
                                    <td>' . $row2['g_name'] . '</td>
                                    <td>' . $row2['g_address'] . '</td>
                                    <td>' . $row2['g_zipcode'] . '</td>
                                    <td>' . $row2['g_city'] . '</td>
                                    <td>' . $row2['g_email'] . '</td>
                                    <td>' . $row2['g_phone'] . '</td>
                                    <td>' . $row2['g_licence'] . '</td>
                                    <td>' . $row2['g_registrationdate'] . '</td>
                                </tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Garages table End  -->


            </div>
        </main>
    </div>


    


    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->
</body>

</html>