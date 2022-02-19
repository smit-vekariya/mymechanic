<?php
session_start();
// admin adding php code start
$alerterror = false;
$alertsuccess = false;
$catby = $_SESSION['userid'];

include 'partials/_dbconnect.php';
if (isset($_GET['addcat'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $catname = $_POST['catname'];
        $catdes = $_POST['catdes'];
        $catimage = addslashes(file_get_contents($_FILES['catimage']['tmp_name']));

        $imagevalid = false;
        $allowed_image_extension = array("png", "jpg", "jpeg");
        $file_extension = pathinfo($_FILES["catimage"]["name"], PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["catimage"]["size"] > 1000000)) {
            $imagevalid = true;
        }

        
        if ($imagevalid == true) {
            $alerterror .= "<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
        } else {
            $sql4 = "INSERT INTO `category` (`cat_image`, `cat_name`, `cat_description`,`cat_by`) VALUES ('$catimage','$catname','$catdes','$catby')";
            $result4 = mysqli_query($conn, $sql4);
            if ($result4) {
                header('location: categories.php?alertsuccess');
            } else {
                die(mysqli_error($conn));
            }
        }
    }
}
// admin adding php code end

//admin delete php code start
if (isset($_GET['delcat'])) {
    $code = $_GET['delcat'];
    $delcategory = "DELETE FROM `category` where cat_id = $code";
    $result2 = mysqli_query($conn, $delcategory);
    if ($result2) {
        $alertsuccess = "Category deleted successfully!!";
    } else {
        $alerterror = "can not delete the category!!";
    }
}
//admin delete php code End


//update category start
if (isset($_GET['updateapply'])) {
    $updatecatid = $_GET['updateapply'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $updatecatname = $_POST['updatecatname'];
        $updatecatdes = $_POST['updatecatdes'];
        $updateapplyquery = "";
        $updatecatby =  $_SESSION['userid'];;
        $imagevalid = false;
        if (($_FILES['updatecatimage']['tmp_name']) != "") {
            $updatecatimage = addslashes(file_get_contents($_FILES['updatecatimage']['tmp_name']));
            $updateapplyquery = "UPDATE `category` SET `cat_image` = '$updatecatimage',`cat_name` = '$updatecatname', `cat_description` = '$updatecatdes', `cat_by` = '$updatecatby' WHERE `category`.`cat_id` = $updatecatid";

            $allowed_image_extension = array("png", "jpg", "jpeg");
            $file_extension = pathinfo($_FILES["updatecatimage"]["name"], PATHINFO_EXTENSION);
            if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["updatecatimage"]["size"] > 1000000)) {
                $imagevalid = true;
            }
        } else {
            $updateapplyquery =  "UPDATE `category` SET `cat_name` = '$updatecatname', `cat_description` = '$updatecatdes',`cat_by` = '$updatecatby' WHERE `category`.`cat_id` = $updatecatid";
        }


        if ($imagevalid == true) {
            $alerterror = "Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
        } else {
            $updateapply = $updateapplyquery;
            $applyresult = mysqli_query($conn, $updateapply);
            if ($applyresult) {
                $alertsuccess = "Category Updated succesfully";
            } else {
                $alerterror = "Sorry!! We can not update category";
            }
        }
    }
}
//update category End

//Active and Deactive action Code
if (isset($_GET['cat_active']) || isset($_GET['cat_deactive'])) {
    $statusupdate = "";
    if (isset($_GET['cat_active'])) {
        $cat_id = $_GET['cat_active'];
        $statusupdate = "UPDATE `category` SET `cat_status` = 'Active' WHERE `category`.`cat_id` = '$cat_id'";
        $statusmessage = "Category Activated Successfully!!";
    }
    if (isset($_GET['cat_deactive'])) {
        $cat_id = $_GET['cat_deactive'];
        $statusupdate = "UPDATE `category` SET `cat_status` = 'Deactive' WHERE `category`.`cat_id` = '$cat_id'";
        $statusmessage = "Category Deactivated Successfully!!";
    }
    $statusresult = mysqli_query($conn, $statusupdate);
    if ($statusresult) {
        $alertsuccess = $statusmessage;
    } else {
        $alerterror = "Can not change the category status";
    }
}
?>


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
                <h1 class="mt-4"><i class="bi bi-bookmark-check-fill"></i> Categories</h1>
                <hr>
                <!-- Alert messages  -->
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
            <strong>Sorry!</strong>We are facing some issue, Can not add category!!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
                ?>
                <?php
                if (isset($_GET['alertsuccess']))
                    echo '<div class="alert alert-success alert-dismissible fade show mx-2" role="alert">
                    <i class="bi bi-check-circle-fill"> </i><strong>Success!! </strong>Category Added successfully!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                ?>
                <!-- Alert messages  -->


                <!-- category update section  -->
                <?php
                if (isset($_GET['updatecat'])) {



                    $catid = $_GET['updatecat'];
                    $updatesql = "SELECT *FROM `category` WHERE `cat_id` = $catid";
                    $updateresult = mysqli_query($conn, $updatesql);
                    while ($catrow = mysqli_fetch_assoc($updateresult)) {
                        $catimage = "data:image/jpg;base64," . base64_encode($catrow['cat_image']);
                        $catname  = $catrow['cat_name'];
                        $catdes = $catrow['cat_description'];
                    }
                    echo '
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


                    <div class="modal-content my-5" id="updatemodal">
                    <div class="modal-header my-header">
                    <h5 class="modal-title" ><strong>Update (' . $catname . ')</strong></h5>
                    <a href="categories.php" type="button" class="btn-close"></a>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="categories.php?updateapply=' . $catid . '" class="customer-form" enctype="multipart/form-data">
                    <div id="catphoto">
                    <label for="updatecatimage">
                        <img src="' . $catimage . '" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change category Photo">
                    </label>
                    <label for="updatecatimage" style="cursor: pointer"><h5>Update Image</h5></label>
                    <input id="updatecatimage"  name="updatecatimage" type="file" />
                    </div>
                        <input type="text" maxlength="30" class="form-control my-1" id="updatecatname" value="' . $catname . '" name="updatecatname" placeholder="Enter Category Name" required="required" />
                        <textarea maxlength="100" class="form-control my-1" id="updatecatdes" name="updatecatdes" placeholder="Enter Category Description" required="required">' . $catdes . '</textarea>
                        <p style="margin-bottom: 0px; font-size: 14px; color: black;">Category By :</p>
                        <input type="text" maxlength="30" class="form-control my-1" id="updatecatby" value="' . $garagerow['g_name'] . '" name="updatecatby" disabled>
                        <button type="submit" class="btn btn-success my-3"><i class="bi bi-pencil-fill"></i>  Update</button>
                        <a href="categories.php" type="button" class="btn btn-danger my-3"><i class="bi bi-x-circle"></i>  Cancel</a>
                    </form>
                    </div>
                    </div>
    
                    </div>
                    </div>';
                }
                ?>
                <!-- category update section  -->




                <!-- category table start  -->
                <div id="Admin">
                    <div class="card mb-4">
                        <div class="card-header" style="background-color:#f3f3f3;">
                            <i class="fas fa-table me-1"></i>
                            Categories Table
                            <button type="button" style="float:right;" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#addcat"><i class="bi bi-plus"></i> Add Category</button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple4">
                                <thead>
                                    <tr class="table-dark">
                                        <th>category ID</th>
                                        <th>Category Image</th>
                                        <th>Category Name</th>
                                        <th>Category Description</th>
                                        <th>Category By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>category ID</th>
                                        <th>Category Image</th>
                                        <th>Category Name</th>
                                        <th>Category Description</th>
                                        <th>Category By</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql1 = "SELECT *FROM `category` WHERE `cat_by` = $catby";
                                    $result1 = mysqli_query($conn, $sql1);
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        $cat_photo = "data:image/jpg;base64," . base64_encode($row1['cat_image']);
                                        $cat_status = $row1['cat_status'];

                                        echo '<tr class="table-light" >
                                        <td scope="row">' . $row1['cat_id'] . '</th>
                                        <th scope="row"><img src=' . $cat_photo . ' style="height: 80px; width: 80px;"></th>
                                        <td>' . $row1['cat_name'] . '</td>
                                        <td>' . $row1['cat_description'] . '</td>
                                        <td>' .  $garagerow['g_name']  . '</td>
                                        <td>
                                        <div id="catbuttons">
                                        <a href="categories.php?delcat=' . $row1['cat_id'] . '"  type="button"  class="btn btn-danger  btn-sm mx-1"><i class="bi bi-trash"></i></a>
                                        <a href="categories.php?updatecat=' . $row1['cat_id'] . '"  type="button" class="btn btn-success  btn-sm mx-1"><i class="bi bi-pencil-fill"></i></a>';
                                        if ($cat_status == "Active") {
                                            echo '<a href="categories.php?cat_deactive=' . $row1['cat_id'] . '"  type="button" class="btn btn-danger  btn-sm mx-1"><i class="bi bi-slash-circle"> </i> </a>';
                                        } else {
                                            echo '<a href="categories.php?cat_active=' . $row1['cat_id'] . '"  type="button" class="btn btn-primary  btn-sm mx-1"><i class="bi bi-check-lg"> </i> </a>';
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
                <!-- category table End  -->






            </div>
        </main>
    </div>

    <!-- add category modal start  -->
    <div class="modal fade " id="addcat" tabindex="-1" aria-labelledby="addcat" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcat">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addcat=true'; ?>" class="customer-form" enctype="multipart/form-data">
                        <input type="text" maxlength="30" class="form-control my-1" id="catname" name="catname" placeholder="Enter Category Name" required="required" />
                        <textarea maxlength="100" class="form-control my-1" id="catdes" name="catdes" placeholder="Enter Category Description" required="required"></textarea>
                        <div style="width:100%">
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Category Image :</p>
                            <input type="file" class="form-control" id="catimage" name="catimage" required="required" />
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Category By :</p>
                            <input type="text" maxlength="30" class="form-control" id="catby" name="catby" value="<?php echo $garagerow['g_name'] ?>" disabled>
                        </div>
                        <button type="submit" class="btn btn-success my-3"><i class="bi bi-plus-circle"></i> Add Category</button>
                        <button type="button" class="btn btn-danger my-3" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancel</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- add category modals end -->

    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->

</body>

</html>