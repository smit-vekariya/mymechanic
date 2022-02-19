<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- including head start  -->
    <?php include 'partials/head.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    <!-- including head start  -->

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <hr>
                <!-- today statistics start  -->
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                        <h3><i class="bi bi-bar-chart-fill"></i> Total statistics</h3>
                    </li>
                </ol>
                <section class="statistic statistic2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item statistic__item--red">
                                    <?php
                                    $sql1 = "SELECT *FROM `customer`";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $num1 = mysqli_num_rows($result1);

                                    ?>
                                    <h2 class="number"><?php echo $num1 ?></h2>
                                    <span class="desc">total Customers</span>
                                    <div class="icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item statistic__item--orange">
                                    <?php
                                    $sql2 = "SELECT *FROM `garage_owner`";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $num2 = mysqli_num_rows($result2);
                                    ?>
                                    <h2 class="number"><?php echo $num2 ?></h2>
                                    <span class="desc">Toal Garages</span>
                                    <div class="icon">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item statistic__item--blue">
                                    <?php
                                    $sql3 = "SELECT *FROM `service`";
                                    $result3 = mysqli_query($conn, $sql3);
                                    $num3 = mysqli_num_rows($result3);
                                    ?>
                                    <h2 class="number"><?php echo $num3 ?></h2>
                                    <span class="desc">Total Services</span>
                                    <div class="icon">
                                        <i class="bi bi-cart-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Total statistics End  -->

                <!-- today statistics start  -->
                <hr>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                        <h3><i class="bi bi-bar-chart"></i> Today's statistics</h3>
                    </li>
                </ol>
                <section class="statistic statistic2">
                    <div class="container">
                        <div class="row">
                        <div class="col-md-6 col-lg-3">
                        <div class="statistic__item statistic__item--grey">
                            <h1><i class="bi bi-person-plus-fill todayi" id="todayi1"></i></h1>
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                           $date = date('Y-m-d', time());
                            $sql4 = "SELECT *FROM `customer` WHERE `c_registrationdate` = '$date' ";
                            $result4 = mysqli_query($conn, $sql4);
                            $num4 = mysqli_num_rows($result4);
                            ?>
                            <h2 class="todaystath1"><?php echo $num4 ?></h2>
                            <span class="todaystatp">Customers Joined Today</span>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item statistic__item--grey">
                            <h1><i class="bi bi-hammer todayi" id="todayi2"></i></h1>
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                           $date = date('Y-m-d', time());
                            $sql5 = "SELECT *FROM `garage_owner` WHERE `g_registrationdate` = '$date' ";
                            $result5 = mysqli_query($conn, $sql5);
                            $num5 = mysqli_num_rows($result5);
                            ?>
                            <h2 class="todaystath1"><?php echo $num5 ?></h2>
                            <span class="todaystatp">Garages Joined Today</span>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="statistic__item statistic__item--grey">
                            <h1><i class="bi bi-cart-check-fill todayi" id="todayi3"></i></h1>
                            <h2 class="todaystath1">10</h2>
                            <span class="todaystatp">Services Booked Today</span>
                        </div>
                    </div>
                        </div>
                    </div>
                </section>
                <!-- today statistics end  -->


                <!-- table start  -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Today's Service Booking
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    <td>$320,800</td>
                                </tr>
                                <tr>
                                    <td>Garrett Winters</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>63</td>
                                    <td>2011/07/25</td>
                                    <td>$170,750</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->
</body>

</html>