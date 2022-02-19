<?php
session_start();
include 'partials/_dbconnect.php';
$alerterror = false;
$alertsuccess = false;
$gr_id = $_SESSION['userid'];

$gdetail = "SELECT *FROM `garage_owner` WHERE `g_id` = '$gr_id'";
$gresult = mysqli_query($conn, $gdetail);
$grow = mysqli_fetch_assoc($gresult);

$grdetail = "SELECT *FROM `garages` WHERE `gr_id` = '$gr_id'";
$grresult = mysqli_query($conn, $grdetail);
$grrow = mysqli_fetch_assoc($grresult);
$num2 = mysqli_num_rows($grresult);

if ($num2 > 0) {
    $gr_name = $grow['g_name'];
    $gr_address = $grow['g_address'];
    $gr_phone = $grow['g_phone'];
    $gr_email = $grow['g_email'];
    $grl_photo = "data:image/jpg;base64," . base64_encode($grrow['grl_photo']);
    $gr_about = $grrow['gr_About'];
    $gr_s1 = $grrow['gr_special1'];
    $gr_s2 = $grrow['gr_special2'];
    $gr_status = $grrow['gr_status'];
    
}

?>

<!--  ---------------Adding label information start------------ -->
<?php
if (isset($_GET['addlabel'])) {
    $g_id = $gr_id;
    $gr_about = $_POST['garageabout'];
    $grl_photo = addslashes(file_get_contents($_FILES['garagephoto']['tmp_name']));
    $gr_special1 = $_POST['spc1'];
    $gr_special2 = $_POST['spc2'];
    $gr_status = "requested";

    $catdetail = "SELECT *FROM `category` WHERE `cat_by` = '$gr_id'";
    $catresult = mysqli_query($conn, $catdetail);
    $totalcat = mysqli_num_rows($catresult);

    $sdetail = "SELECT *FROM `service` WHERE `s_by` = '$gr_id'";
    $sresult = mysqli_query($conn, $catdetail);
    $totals = mysqli_num_rows($sresult);

    $imagevalid = false;
    $allowed_image_extension = array("png", "jpg", "jpeg");
    $file_extension = pathinfo($_FILES["garagephoto"]["name"], PATHINFO_EXTENSION);
    if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["garagephoto"]["size"] > 1000000)) {
        $imagevalid = true;
    }
    if ($totalcat < 2 || $totals < 1 || $imagevalid == true) {
        if ($totalcat < 2 || $totals < 1) {
            $alerterror = "Please Enter At least 3 Category and 10 service  in Your Garage!!";
        }
        if ($imagevalid == true) {
            $alerterror .= "<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
        }
    } else {
        $insertgarage = "INSERT INTO `garages` (`gr_id`, `gr_About`, `grl_photo`, `gr_special1`, `gr_special2`, `gr_category`, `gr_service`, `gr_status`) VALUES ('$g_id','$gr_about','$grl_photo','$gr_special1','$gr_special2','$totalcat','$totals','$gr_status')";

        $insertresult = mysqli_query($conn, $insertgarage);
        if ($insertresult) {
            header('location: mygarage.php');
        } else {
            die(mysqli_error($conn));
        }
    }
}
?>
<!-- -----------Adding label information End--------------------- -->
<!-- -----------update label information End--------------------- -->
<?php
if (isset($_GET['updateapply'])) {
    $uplabout = $_POST['uplabout'];
    $uplspc1 = $_POST['uplspc1'];
    $uplspc2 = $_POST['uplspc2'];

    $imagevalid = false;
    if (($_FILES['uplphoto']['tmp_name']) != "") {
        $uplphoto = addslashes(file_get_contents($_FILES['uplphoto']['tmp_name']));
        $updateapplyquery = "UPDATE `garages` SET `gr_About` = '$uplabout',`grl_photo` = '$uplphoto',`gr_special1` = '$uplspc1',`gr_special2` = '$uplspc2' WHERE `garages`.`gr_id` = $gr_id";

        $allowed_image_extension = array("png", "jpg", "jpeg");
        $file_extension = pathinfo($_FILES["uplphoto"]["name"], PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["uplphoto"]["size"] > 1000000)) {
            $imagevalid = true;
        }
    } else {
        $updateapplyquery = "UPDATE `garages` SET `gr_About` = '$uplabout',`gr_special1` = '$uplspc1',`gr_special2` = '$uplspc2' WHERE `garages`.`gr_id` = $gr_id";
    }
    if($imagevalid == true){
        $alerterror = "Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
    }
    else{
        $upl = mysqli_query($conn,$updateapplyquery);
        if($upl){
            header('location: mygarage.php');
        }
        else{
            die(mysqli_error($conn));
        }
    }
}
?>
<!-- -----------update label information End--------------------- -->

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
<style>
    .garage-body {
        content: "";
        position: absolute;
        z-index: -1;
        opacity: 0.9;
        background: linear-gradient(rgba(0, 0, 0, 0.61), rgba(0, 0, 0, 0.596)), url(<?php echo $grl_photo ?>)no-repeat center center/cover;
        width: 100%;
        height: 350px;
        overflow: auto;
    }
</style>

<body class="sb-nav-fixed">
    <!-- including head start  -->
    <?php include 'partials/head.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    <!-- including head start  -->

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

                <?php
                if ($num2 < 1) {
                    echo '<div class="alert alert-danger my-2 alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Notice!</strong>We need Some basic Label information to verfy and show your garage in website 
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addlabel">
            Add Label information
            </button>
          </div>';
                }
                ?>

                <?php
                if ($alerterror)
                    echo '<div class="alert alert-danger alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Sorry!</strong> ' . $alerterror . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>

                <?php
                if ( $num2 > 0 && $gr_status == "requested")
                    echo '<div class="alert alert-primary my-3 alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Notice!!!</strong> We requested admin to verify your garage, wait till their response
            if it will verify succesully you will see <i class="bi bi-check-circle-fill" style="color:green"></i> in side <strong>"Garage Owner"</strong> in side bar.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>
                <?php
                if ($num2 > 0 && $gr_status == "disapproved")
                    echo '<div class="alert alert-danger my-3 alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Notice!!!</strong>Admin disapprove your garage verificsation please update your profile and garage related inforamation. 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>





                <!-- External label start------------------------------------------------------------------ -->
                <?php
                if ($num2 > 0) {
                    echo '<h4 class="mt-4"><i class="bi bi-bookmark-check-fill"></i>View of Internal label</h4>
                    <a href="mygarage.php?updatelabel"  type="button" class="btn btn-success  btn-sm mx-1"><i class="bi bi-pencil-fill"></i> Edit Label</a>

                <hr>

                <div class="card mx-5  garage-label">
                    <div class="garage-card-header">
                        <h5 class="my-1 px-3">' . $gr_name . '  </h5>
                        <p class="px-1 my-1"><i style="color:rgb(204, 0, 0)" class="bi bi-phone-fill"></i> ' . $gr_phone . '</p>
                        <p class="px-1 my-1"><i style="color:green" class="bi bi-envelope-fill"></i> ' . $gr_email . '</p>
                    </div>
                    <div class="card-body text-light garage-body mt-5 ">
                        <h5 class="card-title mt-5" style="color:rgb(0, 177, 0)"><i class="bi bi-geo-alt-fill"></i>
                            Garage Address</h5>
                        <p class="card-text">' . $gr_address . '</p>
                        <h5 class="card-title mt-4" style="color:rgb(0, 177, 0)"><i class="bi bi-question-circle-fill"></i> About Us
                        </h5>
                        <p class="card-text">' . $gr_about . '</p>
                        <h5 class="card-title mt-4" style="color:rgb(0, 177, 0)"><i class="bi bi-tools"></i> Popular
                            Categories</h5>
                        <p><i class="bi bi-check-circle" style="color:red"></i> ' . $gr_s1 . '</p>
                        <p><i class="bi bi-check-circle" style="color:red"></i> ' . $gr_s2 . '</p>
                    </div>
                </div>
                
                <!-- External label End------------------------------------------------------------------ -->



                <!-- internal label start------------------------------------------------------------------ -->
                <div style="margin-top:400px">
                    <h4 class="mt-4"><i class="bi bi-bookmark-check-fill"></i>View of External label</h4>
                    <hr>

                    <div class="card mx-5  garage-card" style="width: 18rem;">
                        <img src="' . $grl_photo . '" class="card-img-top" alt="Upload image">
                        <div class="garage-card-body">
                            <h4 class="card-title" style="margin-top:5px"><strong>' . $gr_name . '</strong></h4>
                            <p class="card-text"><i class="bi bi-geo-alt-fill" style="color: red; font-size: 20px;"></i>   ' . $gr_address . '</p>
                        </div>
                        <div class="sub-service-div ">
                            <hr style="margin: 0px">
                            <p id="popular-item">Popular Categories</p>
                            <p><i class="bi bi-check-circle"></i> ' . $gr_s1 . '</p>
                            <p><i class="bi bi-check-circle"></i> ' . $gr_s2 . '</p>
                            <hr style="margin: 0px">
                        </div>
                        <div class="garage-card-body garage-buttons">
                            <button type="button" class="btn btn-danger btn-sm">View Garage</button>
                            <a href="#" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                        </div>
                    </div>
                </div>';
                }
                ?>
                <!-- internal label End------------------------------------------------------------------ -->



























            </div>
        </main>
    </div>


    <!-- Update label modal start  -->
    <?php
    if (isset($_GET['updatelabel'])) {
        echo '<script>
        window.onload = function() {
            document.getElementById("clickme").click();
        }
    </script>
    <button type="button" style="display:none" id="clickme" data-bs-toggle="modal" data-bs-target="#updatelabel">
        Launch demo modal
    </button>




    <div class="modal fade " id="updatelabel" tabindex="-1" aria-labelledby="addlabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcat">Add Label Information</h5>
                    <a  href="mygarage.php" type="button" class="btn-close"></a>
                </div>
                <div class="modal-body">
                    <form method="POST" action="mygarage.php?updateapply" class="customer-form" enctype="multipart/form-data">

                    <div class="alert alert-danger" role="alert">
                    Some inforamation  direct come from your profile so if you want Edit it Go to Your profile in mymechanic.
                    </div>

                    <div id="catphoto">
                    <label for="uplphoto">
                        <img src="' . $grl_photo . '"  data-bs-toggle="tooltip" data-bs-placement="right" title="Change category Photo">
                    </label>
                    <label for="uplphoto" style="cursor: pointer"><h5>Update Image</h5></label>
                    <input id="uplphoto"  name="uplphoto" type="file" />
                    </div>

                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">About Garage : </p>
                        <textarea type="text" maxlength="100" class="form-control my-1" id="uplabout" name="uplabout" placeholder="Enter About Information of Garage" required="required">' . $gr_about . '</textarea>

                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">Special Category 1: </p>
                        <input type="text" maxlength="30" value="' . $gr_s1 . '" class="form-control my-1" id="uplspc1" name="uplspc1" placeholder="apecial category 1" required="required" />
                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">special Category 2 : </p>
                        <input type="text" maxlength="30" value="' . $gr_s2 . '" class="form-control my-1" id="uplspc2" name="uplspc2" placeholder="Special Category 2" required="required" />


                        <button type="submit" class="btn btn-success my-3"><i class="bi bi-plus-circle"></i> Add Category</button>
                        <a  href="mygarage.php" type="button" class="btn btn-danger my-3" ><i class="bi bi-x-circle"></i> Cancel</a>
                    </form>
                </div>

            </div>
        </div>
    </div>';
    }
    ?>
    <!-- Update label modals end -->



    <!-- add label modal start  -->
    <div class="modal fade " id="addlabel" tabindex="-1" aria-labelledby="addlabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcat">Add Label Information</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addlabel=true'; ?>" class="customer-form" enctype="multipart/form-data">

                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage phtoto : (Not Garage Owner photo)</p>
                        <input type="file" class="form-control" id="garagephoto" name="garagephoto" required="required" />

                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">About Garage : </p>
                        <textarea type="text" maxlength="100" class="form-control my-1" id="garageabout" name="garageabout" placeholder="Enter About Information of Garage" required="required"></textarea>

                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">Special Category 1: </p>
                        <input type="text" maxlength="30" class="form-control my-1" id="spc1" name="spc1" placeholder="Enter About Information of Garage" required="required" />
                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">special Category 2 : </p>
                        <input type="text" maxlength="30" class="form-control my-1" id="spc2" name="spc2" placeholder="Enter About Information of Garage" required="required" />


                        <button type="submit" class="btn btn-success my-3"><i class="bi bi-plus-circle"></i> Submit</button>
                        <button type="button" class="btn btn-danger my-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancel</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- add label modals end -->

    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->
</body>

</html>