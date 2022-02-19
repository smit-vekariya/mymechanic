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

    $checkbooks = "SELECT *FROM `bookmark` WHERE `book_type` ='garage' AND `book_type_id` ='$s_id' AND `user_id` = '$user_id'	 ";
    $checkbooksresult = mysqli_query($conn, $checkbooks);
    $num = mysqli_num_rows($checkbooksresult);

    if ($num >= 1) {
        $delbookmark = "DELETE FROM `bookmark` WHERE `book_type` ='garage' AND `book_type_id` ='$s_id' AND `user_id` = '$user_id'";
        $delbookmarkresult = mysqli_query($conn, $delbookmark);
        header('location: garages.php');
    } else {
        $servicemark = "INSERT INTO `bookmark` (`book_type`, `book_type_id`, `user_id`) VALUES ('garage', '$s_id', '$user_id')";
        $servicemarkresult = mysqli_query($conn, $servicemark);
        header('location: garages.php');
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
                    <h2>View Our Garages <i class="bi bi-gear-fill"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->
    <div class="service">
        <div class="container garage-container">
            <div class="section-header text-center">
                <h2>View Any Garage</h2>
                <p class="my-2">And Book Service</p>
            </div>
            <div class="row">
                <?php
                $gdata = "SELECT *FROM `garages` INNER JOIN `garage_owner` ON garages.gr_id=garage_owner.g_id";
                $gdataresult = mysqli_query($conn, $gdata);

                while ($grrown = mysqli_fetch_assoc($gdataresult)) {
                    $grid = $grrown['gr_id'];
                    $grname = $grrown['g_name'];
                    $graddress = $grrown['g_address'];
                    $grzip = $grrown['g_zipcode'];
                    $grcity = $grrown['g_city'];
                    $grlphoto =  "data:image/jpg;base64," . base64_encode($grrown['grl_photo']);
                    $grspecial1 = $grrown['gr_special1'];
                    $grspecial2 = $grrown['gr_special2'];

                     //checking garage is  book marked or not start
                    if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
                        $user_id = $_SESSION['userid'];
                        $usertype = $_SESSION['usertype'];


                        $checkbooks = "SELECT *FROM `bookmark` WHERE `book_type` ='garage' AND `book_type_id` ='$grid' AND `user_id` = '$user_id'";
                        $checkbooksresult = mysqli_query($conn, $checkbooks);
                        $num = mysqli_num_rows($checkbooksresult);
                        
                    }
                    //checking garage is book marked or not End






                    echo ' <div class="card mx-4 my-3 garage-card" style="width: 18rem;">
                    <img src="'.$grlphoto.'" style="width: 268px; height: 214px;"class="card-img-top" alt="...">
                    <div class="garage-card-body">
                        <h4 class="card-title" style="margin-top:5px"><strong>' . $grname . '</strong></h4>
                        <p class="card-text" style="min-height: 80px;"><i class="bi bi-geo-alt-fill" style="color: red; font-size: 20px;"></i>' . $grcity . '-'.$grzip.'<br>' . $graddress . '</p>
                    </div>
                    <div class="sub-service-div ">
                        <hr style="margin: 0px">
                        <p id="popular-item">Popular Categories</p>
                        <p><i class="bi bi-check-circle"></i> ' . $grspecial1 . '</p>
                        <p><i class="bi bi-check-circle"></i> ' . $grspecial2 . '</p>
                        <hr style="margin: 0px">
                    </div>
                    <div class="garage-card-body garage-buttons">
                        <a href="category.php?garageid=' . $grid . '" type="button" class="btn btn-danger btn-sm">View Garage</a>';
                        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
                            if ($usertype == 'customer') {
                                if ($num >= 1) {
                                    echo '<a href="garages.php?servicemark='.$grid.'" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star-fill" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>';
                                } else {
                                    echo '<a href="garages.php?servicemark='.$grid.'" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>';
                                }
                            }
                        } else {
                            echo '<button type="button"  class="btn btn-white" data-bs-toggle="modal" data-bs-target="#notlogin"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></button>';
                        }



                       
                       
                       
                       
                        
                    echo '</div>
                </div>';
                }
                ?>

            </div>
        </div>
    </div>
    <!-- popular services End -->

















    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>