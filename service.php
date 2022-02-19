<?php
session_start();
?>
<?php
include 'partials\_dbconnect.php';
$alerterror = false;
$alertsuccess = false;

if (isset($_GET['servicemark'])) {
    session_start();
    $s_id = $_GET['servicemark'];
    $user_id = $_SESSION['userid'];

    $checkbooks = "SELECT *FROM `bookmark` WHERE `book_type` ='service' AND `book_type_id` ='$s_id' AND `USER_ID` = '$user_id'	 ";
    $checkbooksresult = mysqli_query($conn, $checkbooks);
    $num = mysqli_num_rows($checkbooksresult);

    if ($num >= 1) {
        $delbookmark = "DELETE FROM `bookmark` WHERE `book_type` ='service' AND `book_type_id` ='$s_id' AND `user_id` = '$user_id'";
        $delbookmarkresult = mysqli_query($conn, $delbookmark);
        header('location: service.php?cat_id=' . $_GET['cat_id'] . '');
    } else {
        $servicemark = "INSERT INTO `bookmark` (`book_type`, `book_type_id`, `user_id`) VALUES ('service', '$s_id', '$user_id')";
        $servicemarkresult = mysqli_query($conn, $servicemark);
        header('location: service.php?cat_id=' . $_GET['cat_id'] . '');
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="MYMECHANIC_CSS/style.css">
    <title>MyMechanic Serice</title>
</head>



<body>
    <!-- include navbar start -->
    <?php include 'partials\_navbar.php'; ?>
    <!-- include navbar End -->
    <!-- include database start -->
    <?php include 'partials\_dbconnect.php'; ?>
    <!-- include database End -->






    <!-- service Heading Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Our Services <i class="bi bi-tools"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->
    <!-- Alert messages  ----------------------------------------------------------------->
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
    <!-- Alert messages  -------------------------------------------------------------------->

    <div class="service">
        <div class="my-container">
            <div class="section-header text-center">
                <h2>Select Any Service</h2>
                <p class="my-2">As Your requirement</p>
            </div>
            <div class="row">

                <?php
                $catid = $_GET['cat_id'];
                $gets = "SELECT *FROM `service` WHERE `cat_id` = $catid AND `s_status` = 'Active' ";
                $getsresult = mysqli_query($conn, $gets);
               





                while ($getsrow = mysqli_fetch_assoc($getsresult)) {
                    $s_img = "data:image/jpg;base64," . base64_encode($getsrow['s_image']);
                    $s_id = $getsrow['s_id'];
                    $s_by = $getsrow['s_by'];
                    //Checckin Who provides Service start
                    if($s_by == 'mymechanic'){
                        $serviceby = 'mymechanic';
                    }
                    else{
                        $findsql = "SELECT *FROM `garage_owner` WHERE `g_id` = '$s_by'";
                        $findres = mysqli_query($conn,$findsql);
                        $findrow = mysqli_fetch_assoc($findres);
                        $serviceby = $findrow['g_name'];


                    }
                    //Checckin Who provides Service start

                    //checking service book marked or not start
                    if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
                        $user_id = $_SESSION['userid'];
                        $usertype = $_SESSION['usertype'];


                        $checkbooks = "SELECT *FROM `bookmark` WHERE `book_type` ='service' AND `book_type_id` ='$s_id' AND `user_id` = '$user_id'	 ";
                        $checkbooksresult = mysqli_query($conn, $checkbooks);
                        $num = mysqli_num_rows($checkbooksresult);
                        
                    }
                    //checking service book marked or not End


                    echo '<div class="card mx-4 my-4 service-card" style="max-width: 540px;">
                    <div class="row g-0 service-body-div">
                        <div class="col-md-4 service-img-div">
                            <img src="' . $s_img . '" class="img-fluid rounded-start" alt="...">
                            <h5 style="color: #bd1828; font-weight: 650; margin-bottom: 2px; margin-top: 10px;">Price ' . $getsrow["s_price"] . '/-</h5>
                            <h6 style="margin-top: 2px;">Rs. Only</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body service-title-des">
                                <h4 class="card-title"><i class="bi bi-check-circle-fill"> </i><strong>' . $getsrow["s_name"] . '</strong></h4>
                                <h6 style="color: rgb(85, 85, 85); min-height:57.56px">' . $getsrow["s_description"] . '</h6>
                            </div>
                            <hr style="margin:0px;  color: #000000;">
                            <div class="sub-service-div">
                                <p><i class="bi bi-check-circle"></i> ' . $getsrow["s_special1"] . '</p>
                                <p><i class="bi bi-check-circle"></i> ' . $getsrow["s_special2"] . '</p>
                                <p><i class="bi bi-check-circle"></i> ' . $getsrow["s_special3"] . '</p>
                                <hr style="margin:0px;  color: #000000;">
                                <p style="font-size:12px"><i class="bi bi-check-circle-fill" style="color:red"></i> <strong>Service By: '.$serviceby.'</strong><p>
                            </div>
                            <hr style="margin:0px;  color: #000000;">';

                    if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
                        if ($usertype == 'customer') {
                            if ($num >= 1) {
                                echo '<div class="service-card-buttons">
                                    <a href="service.php?booking='.$s_id.'&cat_id=' . $catid . '" type="button" class="btn btn-danger btn-sm">Book Service</button>
                                    <a href="service.php?cat_id=' . $catid . '&servicemark=' . $getsrow['s_id'] . '" type="button"data-bs-toggle="tooltip" data-bs-placement="right" title="Remoove from Bookmark" class="btn btn-white"><i type="button" class="bi bi-star-fill" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                                    </div>';
                            } else {
                                echo '<div class="service-card-buttons">
                                    <a href="service.php?booking='.$s_id.'&cat_id=' . $catid . '" type="button" class="btn btn-danger btn-sm">Book Service</button>
                                    <a href="service.php?cat_id=' . $catid . '&servicemark=' . $getsrow['s_id'] . '" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                                    </div>';
                            }
                        }
                    } else {
                        echo '<div class="service-card-buttons">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#notlogin">Book Service</button>
                        <button type="button"  class="btn btn-white" data-bs-toggle="modal" data-bs-target="#notlogin"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></button>
                        </div>';
                    }
                    echo '</div>
                    </div>
                </div>';
                }
                ?>


            </div>
        </div>
    </div>


    <!--  services Card End -->


    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>