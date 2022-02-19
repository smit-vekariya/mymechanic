<!-- ------------------------------------------------------------------------------------------------ -->
<!-- ---------------------------------------PHP Codes--------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------ -->
<?php
session_start();
// service adding php code start
$alerterror = false;
$alertsuccess = false;
$s_by = $_SESSION['userid'];

include 'partials/_dbconnect.php';
if (isset($_GET['addser'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cat_id = $_POST['selectcat'];
        $service_img = addslashes(file_get_contents($_FILES['serimage']['tmp_name']));
        $service_name = $_POST['sername'];
        $service_des = $_POST['serdes'];
        $special1 = $_POST['special1'];
        $special2 = $_POST['special2'];
        $special3 = $_POST['special3'];
        $service_charge = $_POST['sercharge'];

        $imagevalid = false;
        $allowed_image_extension = array("png", "jpg", "jpeg");
        $file_extension = pathinfo($_FILES["serimage"]["name"], PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["serimage"]["size"] > 1000000)) {
            $imagevalid = true;
        }

        if ($imagevalid == true) {
            $alerterror .= "<br> Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
        } else {
            $sql4 = "INSERT INTO `service` (`cat_id`,`s_image`,`s_name`, `s_description`, `s_special1`, `s_special2`, `s_special3`, `s_price`,`s_by`, `s_status`) VALUES ('$cat_id','$service_img', '$service_name', '$service_des', '$special1', '$special2', '$special3', '$service_charge', '$s_by','Active')";
            $result4 = mysqli_query($conn, $sql4);
            if ($result4) {
                header('location: services.php?alertsuccess');
            } else {
                die(mysqli_error($conn));
            }
        }
    }
}
// service adding php code end


//service delete php code start
if (isset($_GET['serdel'])) {
    $code = $_GET['serdel'];
    $delcategory = "DELETE FROM `service` where s_id = $code";
    $result2 = mysqli_query($conn, $delcategory);
    if ($result2) {
        $alertsuccess = "Service deleted successfully!!";
    } else {
        die(mysqli_error($conn));
    }
}
//service delete php code End


//update service start
if (isset($_GET['updateapply'])) {
    $updatesid = $_GET['updateapply'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $updatecat_id = $_POST['updatecat_id'];
        $updateser_name = $_POST['updateser_name'];
        $updateser_des = $_POST['updateser_des'];
        $updatespecial1 = $_POST['updatespecial1'];
        $updatespecial2 = $_POST['updatespecial2'];
        $updatespecial3 = $_POST['updatespecial3'];
        $updateserser_charge = $_POST['updateserser_charge'];
        $upservice_by = $s_by;



        $updateapplyquery = "";
        $imagevalid = false;
        if (($_FILES['updateser_img']['tmp_name']) != "") {
            $updateser_img = addslashes(file_get_contents($_FILES['updateser_img']['tmp_name']));
            $updateapplyquery =  "UPDATE `service` SET `cat_id` = '$updatecat_id', `s_name` = ' $updateser_name', `s_image`='$updateser_img', `s_description` = '$updateser_des', `s_special1` = '$updatespecial1', `s_special2` = '$updatespecial2', `s_special3` = '$updatespecial3', `s_price` = '$updateserser_charge',`s_by` = '$upservice_by'  WHERE `service`.`s_id` = $updatesid;";

            $allowed_image_extension = array("png", "jpg", "jpeg");
            $file_extension = pathinfo($_FILES["updateser_img"]["name"], PATHINFO_EXTENSION);
            if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["updateser_img"]["size"] > 1000000)) {
                $imagevalid = true;
            }
        } else {
            $updateapplyquery =  "UPDATE `service` SET `cat_id` = '$updatecat_id', `s_name` = '$updateser_name', `s_description` = '$updateser_des', `s_special1` = '$updatespecial1', `s_special2` = '$updatespecial2', `s_special3` = '$updatespecial3', `s_price` = '$updateserser_charge',`s_by` = '$upservice_by' WHERE `service`.`s_id` = $updatesid;";
        }


        if ($imagevalid == true) {
            $alerterror = "Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
        } else {
            $updateapply = $updateapplyquery;
            $applyresult = mysqli_query($conn, $updateapply);
            if ($applyresult) {
                $alertsuccess = "Service Updated succesfully";
            } else {
                die(mysqli_error($conn));
            }
        }
    }
}
//update service End

//Active and Deactive action Code
if (isset($_GET['ser_active']) || isset($_GET['ser_deactive'])) {
    $statusupdate = "";
    if (isset($_GET['ser_active'])) {
        $s_id = $_GET['ser_active'];
        $statusupdate = "UPDATE `service` SET `s_status` = 'Active' WHERE `service`.`s_id` = '$s_id'";
        $statusmessage = "Service Activated Successfully!!";
    }
    if (isset($_GET['ser_deactive'])) {
        $s_id = $_GET['ser_deactive'];
        $statusupdate = "UPDATE `service` SET `s_status` = 'Deactive' WHERE `service`.`s_id` = '$s_id'";
        $statusmessage = "Service Deactivated Successfully!!";
    }
    $statusresult = mysqli_query($conn, $statusupdate);
    if ($statusresult) {
        $alertsuccess = $statusmessage;
    } else {
        die(mysqli_error($conn));
    }
}
?>
<!-- ------------------------------------------------------------------------------------------------ -->
<!-- ---------------------------------------PHP Codes--------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------ -->






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<style>
    #clickme {
        display: none;
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
                <h1 class="mt-4"><i class="bi bi-cart-check-fill"></i> Services</h1>
                <hr>


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
                <?php
                if (isset($_GET['alerterror']))
                    echo '<div class="alert alert-danger alert-dismissible fade show" style="width:98%" role="alert">
            <strong>Sorry!</strong>We are facing some issue, Can not add Service!!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>
                <?php
                if (isset($_GET['alertsuccess']))
                    echo '<div class="alert alert-success alert-dismissible fade show mx-2" role="alert">
                    <i class="bi bi-check-circle-fill"> </i><strong>Success!! </strong>Service Added successfully!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                ?>
                <!-- Alert messages  -------------------------------------------------------------------->







                <!-- category update section--------------------------------------------------------------  -->
                <?php
                if (isset($_GET['updateser'])) {

                    $s_id = $_GET['updateser'];
                    $updatesql = "SELECT *FROM `service` WHERE `s_id` = $s_id";
                    $updateresult = mysqli_query($conn, $updatesql);
                    while ($serrow = mysqli_fetch_assoc($updateresult)) {
                        $updatecat_id = $serrow['cat_id'];
                        $updateser_img = "data:image/jpg;base64," . base64_encode($serrow['s_image']);
                        $updateser_name = $serrow['s_name'];
                        $updateser_des = $serrow['s_description'];
                        $updatespecial1 = $serrow['s_special1'];
                        $updatespecial2 = $serrow['s_special2'];
                        $updatespecial3 = $serrow['s_special3'];
                        $updateserser_charge = $serrow['s_price'];
                    }

                    echo  '
                    <script>
                        window.onload = function() {
                            document.getElementById("clickme").click();
                        }
                    </script>
                    <button type="button"  id="clickme"  data-bs-toggle="modal" data-bs-target="#updatecat">
                    Launch demo modal
                    </button>                    
                    <div class="modal fade" id="updatecat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">

   
                    <div class="modal-content my-5 "  id="updatemodal">
                    <div class="modal-header my-header">
                        <h5 class="modal-title"><strong>Update (' . $updateser_name . ')</strong></h5>
                        <a href="services.php" type="button" class="btn-close"></a>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="services.php?updateapply=' . $s_id . '" class="customer-form" enctype="multipart/form-data">

                            <div id="catphoto">
                                <label for="updateser_img">
                                    <img src="' . $updateser_img . '" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change Service Photo">
                                </label>
                                <label for="updateser_img" style="cursor: pointer">
                                    <h5>Update Image</h5>
                                </label>
                                <input id="updateser_img" name="updateser_img" type="file" />
                    </div>


                    <p style="margin-bottom: 0px; font-size: 14px; color: black;">service Category :</p>
                    <select class="form-select form-select" id="updatecat_id" name="updatecat_id" aria-label=".form-select-sm example" required="required">';

                    $selcat = "SELECT *FROM `category` WHERE `cat_by` = $s_by ";
                    $selresult = mysqli_query($conn, $selcat);

                    $selcat2 = "SELECT *FROM `category` WHERE `cat_id` = $updatecat_id ";
                    $selresult2 = mysqli_query($conn, $selcat2);
                    $selcatrow2 = mysqli_fetch_assoc($selresult2);

                    echo "<option selected value=" .  $selcatrow2['cat_id']  . ">" . $selcatrow2['cat_name'] . "</option>";

                    while ($selcatrow = mysqli_fetch_assoc($selresult)) {

                        echo "<option value=" . $selcatrow['cat_id'] . ">" . $selcatrow['cat_name'] . "</option>";
                    }
                    echo '</select>

                        <div style="width:100%" class="my-3">                           
                            <input type="text" maxlength="30" class="form-control my-1" 
                            value="' . $updateser_name . '" id="updateser_name" name="updateser_name" placeholder="Enter Service Name" required="required" />
                            <textarea type="text" maxlength="100"  class="form-control my-1" id="updateser_des" name="updateser_des" placeholder="Enter Service description" required="required" >' . $updateser_des . '</textarea>
                        </div>

                        <div style="width:100%" class="my-3">
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Enter some 3 Functionality of service :</p>
                            <input type="text" maxlength="40" class="form-control my-1" id="updatespecial1" name="updatespecial1" value="' . $updatespecial1 . '" placeholder="Enter Functionality 1" required="required" />
                            <input type="text" maxlength="40" value="' . $updatespecial2 . '" class="form-control my-1" id="updatespecial2" name="updatespecial2" placeholder="Enter Functionality 2" required="required" />
                            <input type="text" maxlength="40" value="' . $updatespecial3 . '" class="form-control my-1" id="updatespecial3" name="updatespecial3" placeholder="Enter Functionality 3" required="required" />
                        </div>

                        <div style="width:100%" class="my-3">
                            <input type="number" maxlength="40" class="form-control my-1" id="updateserser_charge" name="updateserser_charge" value="' . $updateserser_charge . '" placeholder="Enter Service Charge" required="required" />
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Service By :</p>
                            <input type="text" maxlength="30" class="form-control my-1" id="upservice_by" value="' . $garagerow['g_name'] . '" name="upservice_by" disabled>
                        </div>


                        <button type="submit" class="btn btn-success my-3"><i class="bi bi-pencil-fill"></i>  Update</button>
                        <a href="services.php" type="button" class="btn btn-danger my-3"><i class="bi bi-x-circle"></i>  Cancel</a>
                        </form>
                    </div>
                </div>
                </div>
            </div>';
                }
                ?>

                <!-- Service update section------------------------------------------------------>











                <!-- service table start  ------------------------------------------------------->
                <div id="service">
                    <div class="card mb-4">
                        <div class="card-header" style="background-color:#f3f3f3;">
                            <i class="fas fa-table me-1"></i>
                            Service Table
                            <button type="button" style="float:right;" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#addservice"><i class="bi bi-plus"></i> Add Service</button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple5">
                                <thead>
                                    <tr class="table-dark">
                                        <th>service id</th>
                                        <th>Service img</th>
                                        <th>Cat ID</th>
                                        <th>Service name</th>
                                        <th>Service des</th>
                                        <th>Special1</th>
                                        <th>Special2</th>
                                        <th>Special3</th>
                                        <th>service charge</th>
                                        <th>Service By</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>service id</th>
                                        <th>Service img</th>
                                        <th>Cat ID</th>
                                        <th>Service name</th>
                                        <th>Service des</th>
                                        <th>Special1</th>
                                        <th>Special2</th>
                                        <th>Special3</th>
                                        <th>service charge</th>
                                        <th>Service By</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $selectser = "SELECT *FROM `service` WHERE `s_by` = $s_by ";
                                    $selectserresult = mysqli_query($conn, $selectser);
                                    while ($selectserow = mysqli_fetch_assoc($selectserresult)) {
                                        $service_img = "data:image/jpg;base64," . base64_encode($selectserow['s_image']);
                                        $s_status = $selectserow['s_status'];
                                        echo '<tr class="table-light" >
                                     <td scope="row">' . $selectserow['s_id'] . '</th>
                                     <th scope="row"><img src=' . $service_img . ' style="height: 80px; width: 80px;"></th>
                                     <td scope="row">' .  $selectserow['cat_id'] . '</th>
                                     <td scope="row">' .  $selectserow['s_name'] . '</th>
                                     <td scope="row">' .  $selectserow['s_description'] . '</th>
                                     <td>' . $selectserow['s_special1'] . '</td>
                                     <td>' . $selectserow['s_special2'] . '</td>
                                     <td>' . $selectserow['s_special3'] . '</td>
                                     <td>' .  $selectserow['s_price'] . '</td>
                                     <td>' .  $garagerow['g_name'] . '</td>
                                     <td>
                                     <div id="catbuttons">
                                     <a href="services.php?serdel=' . $selectserow['s_id'] . '"  type="button"  class="btn btn-danger  btn-sm mx-1"><i class="bi bi-trash"></i></a>
                                     <a href="services.php?updateser=' . $selectserow['s_id'] . '"  type="button" class="btn btn-success  btn-sm mx-1"><i class="bi bi-pencil-fill"></i></a>';

                                        if ($s_status == "Active") {
                                            echo '<a href="services.php?ser_deactive=' . $selectserow['s_id'] . '"  type="button" class="btn btn-danger  btn-sm mx-1"><i class="bi bi-slash-circle"> </i> </a>';
                                        } else {
                                            echo '<a href="services.php?ser_active=' . $selectserow['s_id'] . '"  type="button" class="btn btn-primary  btn-sm mx-1"><i class="bi bi-check-lg"> </i> </a>';
                                        }


                                        echo '</div>
                                     </td>
                                     </tr>';
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- service table End  ----------------------------------------------------------->




            </div>
        </main>
    </div>




    <!-- add service modal start  -------------------------------------------------------->
    <div class="modal fade " id="addservice" tabindex="-1" aria-labelledby="addservice" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addservice">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addser=true'; ?>" class="customer-form" enctype="multipart/form-data">
                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">service Category :</p>
                        <select class="form-select form-select" id="selectcat" name="selectcat" aria-label=".form-select-sm example" required="required">
                            <?php
                            $selcat = "SELECT *FROM `category` WHERE `cat_by` = $s_by";
                            $selresult = mysqli_query($conn, $selcat);
                            while ($selcatrow = mysqli_fetch_assoc($selresult)) {

                                echo '<option value=' . $selcatrow['cat_id'] . '>' . $selcatrow['cat_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <div style="width:100%" class="my-3">
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">service Image :</p>
                            <input type="file" class="form-control" id="serimage" name="serimage" required="required" />
                            <input type="text" maxlength="30" class="form-control my-1" id="sername" name="sername" placeholder="Enter Service Name" required="required" />
                            <textarea maxlength="100" class="form-control my-1" id="serdes" name="serdes" placeholder="Enter Service description" required="required"></textarea>
                        </div>

                        <div style="width:100%" class="my-3">
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Enter some 3 Functionality of service :</p>
                            <input type="text" maxlength="40" class="form-control my-1" id="special1" name="special1" placeholder="Enter Functionality 1" required="required" />
                            <input type="text" maxlength="40" class="form-control my-1" id="special2" name="special2" placeholder="Enter Functionality 2" required="required" />
                            <input type="text" maxlength="40" class="form-control my-1" id="special3" name="special3" placeholder="Enter Functionality 3" required="required" />
                        </div>

                        <div style="width:100%" class="my-3">
                            <input type="number" maxlength="40" class="form-control my-1" id="sercharge" name="sercharge" placeholder="Enter Service Charge" required="required" />
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Service By :</p>
                            <input type="text" maxlength="30" class="form-control my-1" id="service_by" value="<?php echo $garagerow['g_name'] ?>" name="service_by" disabled>
                        </div>
                        <button type="submit" class="btn btn-success my-3"><i class="bi bi-plus-circle"></i> Add Service</button>
                        <button type="button" class="btn btn-danger my-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add service modals end -------------------------------------------------------------------------->




    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->
</body>

</html>