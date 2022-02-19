<?php
session_start();
include 'partials/_dbconnect.php';
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


    <!-- service Heading Start -->
    <div class="page-header" style="margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Bookings <i class="bi bi-phone-vibrate"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- service Heading End -->

    <div class="service">
        <div class="my-container">
            <div class="section-header text-center">
                <h2>Select Any Service</h2>
                <p class="my-2">As Your requirement</p>
            </div>
            <div class="row" style="flex-direction:column">


                <?php
                $cr_id = $_SESSION['userid'];

                // Fetching Booking  data
                $bookdata = "SELECT *FROM `booking` WHERE `cr_id` = $cr_id ";
                $bookdatares = mysqli_query($conn, $bookdata);
                while ($bookrow = mysqli_fetch_assoc($bookdatares)) {
                    $bookgr = $bookrow['gr_id'];
                    $booksr = $bookrow['sr_id'];

                    $bookdate = $bookrow['bk_date'];
                    $booksrdate = $bookrow['sr_date'];
                    $bookcar = $bookrow['car_model'];
                    $bookcarno = $bookrow['car_no'];
                    $bookdes = $bookrow['sr_description'];
                    $bookstatus = $bookrow['bk_status'];

                    //Service Details Start
                    $serdata = "SELECT *FROM `service` WHERE `s_id` = $booksr";
                    $serresult = mysqli_query($conn,$serdata);
                    $serrow = mysqli_fetch_assoc($serresult);
                    $serphoto = "data:image/jpg;base64," . base64_encode($serrow['s_image']);
                    //Service Details End

                    //Garage Details Start
                    $grvalid = false;
                    if($bookgr == null){
                        $grvalid = "once garage owner accept your service, after that you will able to see garage details here";
                    }
                    else{
                        $grdata = "SELECT *FROM `garage_owner` WHERE `g_id` = $bookgr";
                        $grres = mysqli_query($conn,$grdata);
                        $grrow = mysqli_fetch_assoc($grres);
                    }
                    //Garage Details End

                    //Customer Data start
                    $crdata = "SELECT *FROM `customer` WHERE `c_id` = $cr_id";
                    $crres = mysqli_query($conn,$crdata);
                    $crrow = mysqli_fetch_assoc($crres);
                    //Customer Data End





                    echo '<div class="card mb-3 service-card" style="max-width: 650px; ">
                    <div class="row g-0 service-body-div">
                        <div class="col-md-5 ">
                            <div class="booking-img-div">
                                <img src="'.$serphoto.'" class="img-fluid rounded-start" alt="...">
                                <h6 class="mx-2 no-margin"><strong>'.$serrow['s_name'].'</strong></h6>
                                <p class="mx-2 no-margin" style="color: #c71e2f;"><strong>Price :</strong> '.$serrow['s_price'].' rs.</p>
                            </div>
                            <hr style="margin:4px;  color: #000000;">
                            <div id="garage-details">
                                <p class="small-text my-1 mx-2"><i class="bi bi-truck"></i><strong style="color: #c71e2f;"> Car Details:
                                    </strong>' . $bookcar . '</p>
                                <p class="small-text my-1 mx-2"><i class="bi bi-pip-fill"></i><strong style="color: #c71e2f;"> Vehicle
                                        No: </strong>' . $bookcarno . '</p>
                                <hr style="margin:4px;  color: #000000;">

                                <p class="small-text my-1 mx-2"><i class="bi bi-calendar-event-fill"></i><strong style="color: #c71e2f;">
                                        Booking Date: </strong>' . $bookdate . '</p>
                                <p class="small-text my-1 mx-2"><i class="bi bi-calendar-plus"></i><strong style="color: #c71e2f;">
                                        Service Date: </strong>' . $booksrdate . '</p>
                                <p class="small-text my-1 mx-2"><i class="bi bi-check-circle-fill"></i><strong style="color: #c71e2f;">';
                                        if($bookstatus == "placed"){
                                       echo 'Booking Status: </strong><button type="button" id="status-button-placed" class="btn btn-sm" disabled>' . $bookstatus . '</button>';
                                        }
                                        if($bookstatus == "confirm" || $bookstatus == "complete"){
                                       echo 'Booking Status: </strong><button type="button" id="status-button-confirm" class="btn btn-sm" disabled>' . $bookstatus . '</button>';
                                        }
                                        if($bookstatus == "decline" || $bookstatus == "cancel"){
                                       echo 'Booking Status: </strong><button type="button" id="status-button-cancel" class="btn btn-sm" disabled>' . $bookstatus . '</button>';
                                        }

                                echo'</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <hr style="margin:4px;  color: #000000;">
                            <div class="sub-service-div">
                                <p class="small-text" style="color: rgb(0, 0, 0);"><strong>Garage Owner Deatails :</strong></p>';


                                if($grvalid){
                                    echo '<p class="small-text mx-2" style="background-color: #ff00004d; padding:6px; border-radius:5px;"><i class="bi bi-exclamation-triangle" style="color:red"></i> '.$grvalid.'</p>';
                                }else {
                                echo '<p class="small-text mx-2"><i class="bi bi-gear-fill"></i><strong style="color: #c71e2f;"> Garage
                                        Name: </strong> <a href="category.php?garageid='.$bookgr.'">'.$grrow['g_name'].'</a></p>
                                <p class="small-text mx-2"><i class="bi bi-person-fill"></i><strong style="color: #c71e2f;"> Owner:
                                    </strong>'.$grrow['g_owner_name'].'</p>
                                <p class="small-text mx-2"><i class="bi bi-telephone-fill"></i><strong style="color: #c71e2f;">
                                        Phone: </strong>'.$grrow['g_phone'].'</p>';
                                }


                            echo '</div>
                            <hr style="margin:0px;  color: #000000;">
                            <div class="sub-service-div">
                                <p class="small-text" style="color: rgb(0, 0, 0);"><strong>Customer Deatails :</strong></p>
                                <p class="small-text mx-2"><i class="bi bi-person-circle"></i><strong style="color: #c71e2f;">
                                        Customer Name: </strong>'.$crrow['c_name'].'</p>
                                <p class="small-text mx-2"><i class="bi bi-phone-fill"></i><strong style="color: #c71e2f;"> Phone:
                                    </strong>'.$crrow['c_phone'].'</p>
                            </div>
                            <hr style="margin:0px;  color: #000000;">
                            <div class="sub-service-div">
                                <div>
                                    <div class="form-floating mx-2 my-2">
                                        <textarea id="service-msg" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">'.$bookdes.'</textarea>
                                        <label for="floatingTextarea2">Service description</label>
                                    </div>
                                    <button style="display:block; margin:auto;" type="button" class="btn btn-danger my-2 btn-sm">Cancel Service</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                }

                ?>

            </div>
        </div>
    </div>






    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>