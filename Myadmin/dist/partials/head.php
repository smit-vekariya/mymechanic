<?php
//
include '_dbconnect.php';
if(isset($_GET['delfeed'])){
    $qid = $_GET['delfeed'];
    $delquery = "DELETE FROM `feedback` WHERE `q_id` = $qid";
    $delresult = mysqli_query($conn,$delquery);
}
//
echo '<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
<!-- Navbar Brand-->
<a class="navbar-brand ps-3" href="index.php">Start Bootstrap</a>
<!-- Sidebar Toggle-->
<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
<!-- Navbar Search-->

<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <div class="input-group">
        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
    </div>
</form>
<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm position-relative mx-3 my-2">
<i class="bi bi-envelope-fill"></i>
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    99+
    <span class="visually-hidden">unread messages</span>
  </span>
</button>

<!-- Navbar-->

</nav>
<div id="layoutSidenav">
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a> 
                <div class="sb-sidenav-menu-heading">Service & Category</div>  
                <a class="nav-link" href="categories.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-bookmark-check-fill"></i></div>
                    Categories
                </a>    
                <a class="nav-link" href="services.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-cart-check-fill"></i></div>
                    Services
                </a>
                <a class="nav-link" href="approve.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-check-circle-fill"></i></div>
                    Garage Approve
                </a>
               

                <div class="sb-sidenav-menu-heading">Users Data</div>
                <a class="nav-link" href="admin.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-person-fill me-2"></i></div>
                    Admin
                </a>
                <a class="nav-link" href="customer.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-people-fill me-2"></i></div>
                    Customers
                </a>
                <a class="nav-link" href="garageowner.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-hammer me-2"></i></div>
                    Garage Owners
                </a>
                
                
                
            </div>
        </div>
        <div class="sb-sidenav-footer">';
if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true && ($_SESSION['usertype'] == 'admin')) {
    $adminmail = $_SESSION['email'];
    $admindata = "SELECT *FROM `admin` WHERE `a_email` = '$adminmail' ";
    $admindataresult = mysqli_query($conn, $admindata);
    $adminrow = mysqli_fetch_assoc($admindataresult);
    $admin_photo = "data:image/jpg;base64," . base64_encode($adminrow['a_photo']);


    echo '
        <img src=' . $admin_photo . ' style="height: 40px; width:40px;" class="rounded-circle" ">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updateadmin">' . $adminmail . '</button>
        </div>';
} else {
    header('location: http://localhost/final-project/MyMechanic/index.php');
}
echo '</nav>
        </div>';
?>

<?php
//admin update PHP Code
if (isset($_GET['updateadmin'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uadminname = $_POST['uadminname'];
        $uadminemail = $_POST['uadminemail'];
        $uadminpassword = $_POST['uadminpassword'];
        $updateapplyquery = "";
        $hashpass = $adminrow['a_password'];
        $adminid = $adminrow['a_id'];

        $passwordvalid = false;
        $imagevalid = false;
        if (($_FILES['uadminphoto']['tmp_name']) != "") {
            $uadminphoto = addslashes(file_get_contents($_FILES['uadminphoto']['tmp_name']));
            $updateapplyquery = "UPDATE `admin` SET `a_photo` = '$uadminphoto', `a_name` = '$uadminname', `a_email` = '$uadminemail' WHERE  `admin`.`a_id` = $adminid";

            $allowed_image_extension = array("png", "jpg", "jpeg");
            $file_extension = pathinfo($_FILES["uadminphoto"]["name"], PATHINFO_EXTENSION);
            if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["uadminphoto"]["size"] > 1000000)) {
                $imagevalid = true;
            }
        } else {
            $updateapplyquery = "UPDATE `admin` SET  `a_name` = '$uadminname', `a_email` = '$uadminemail' WHERE `admin`.`a_id` = $adminid";
        }
        if (!password_verify($uadminpassword, $hashpass)) {
            $passwordvalid = true;
        }

        if ($imagevalid == true || $passwordvalid == true) {
            if ($passwordvalid == true) {
                $alerterror = "<br>- Please Enter Valid Password";
            }
            if ($imagevalid == true) {
                $alerterror .= "<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB";
            }
        } else {
            $updateapply = $updateapplyquery;
            $applyresult = mysqli_query($conn, $updateapply);
            if ($applyresult) {
                $alertsuccess = "Admin Profile Updated succesfully";
            } else {
                die(mysqli_error($conn));
            }
        }
    }
}
//admin update PHP Code
$selfpath = $_SERVER['PHP_SELF'];
$admin_photo = "data:image/jpg;base64," . base64_encode($adminrow['a_photo']);
echo  '<div class="modal fade" id="updateadmin" tabindex="-1" aria-labelledby="updateadmin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateadmin">Admin Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="admin.php?updateadmin=' . $adminrow['a_id'] . '" class="customer-form" enctype="multipart/form-data">
                    <div id="catphoto">
                    <label for="uadminphoto">
                        <img src="' . $admin_photo . '" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change category Photo">
                    </label>
                    <label for="uadminphoto" style="cursor: pointer"><h5>Update Image</h5></label>
                    <input id="uadminphoto"  name="uadminphoto" type="file" />
                    </div>
                        <input type="text" maxlength="30" class="form-control my-1" id="uadminname" name="uadminname" value="' . $adminrow['a_name'] . '" placeholder="Enter Admin Name" required="required" />
                        <input type="email" maxlength="50" class="form-control my-1" id="uadminemail" name="uadminemail" value="' . $adminrow['a_email'] . '" placeholder="Enter Admin E-Mail" required="required" />
                        <input type="password" maxlength="30" class="form-control my-1" id="uadminpassword" name="uadminpassword"  placeholder="Enter Password" required="required" />
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i>  update</button>
                        <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#logoutask"> <i class="bi bi-box-arrow-right"></i>  Logout</button>
                        <a href="http://localhost/final-project/MyMechanic/index.php" style="float:right" class="btn btn-secondary">Go to MyMechanic</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutask" tabindex="-1" aria-labelledby="logoutaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div style="border-radius: 25px; background-color: white" class="modal-content">
            <div class="modal-header">
                <a href="' . $selfpath . '" type="button" class="btn-close"  aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <h2 style="text-align: center"><strong>Do You really want to logout?</strong></h2>
            </div>
            <div style="margin:auto" class="modal-footer">
                <a href="http://localhost/final-project/MyMechanic/partials/_logout.php" class="btn btn-danger">Logout</a>
                <a  href="'.$selfpath.'" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
        </div>
    </div>




    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
        <div style="border-radius: 25px; background-color: white;"  class="modal-content">
            <div class="modal-header">
            <h4 style="text-align: center"><strong>Feedbacks and messages <i class="bi bi-envelope-fill"></i></strong></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
            </div>
            <div style="margin:auto" class="modal-footer overflow-auto">
            <table  id="messagemodal">
            <thead>
                <tr class="table-dark">
                    <th>Date</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>Date</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Action</th>
                </tr>
            </tfoot>
            <tbody>';
                    $querysql = "SELECT *FROM `feedback`";
                    $querresult = mysqli_query($conn, $querysql);
                    
                    
                    while($queryrow = mysqli_fetch_assoc($querresult)){

                    echo '<tr>
                            <td>' . $queryrow['q_date'] . '</td>
                            <td>' . $queryrow['q_name'] . '</td>
                            <td>' . $queryrow['q_email'] . '</td>
                            <td>' . $queryrow['q_phone'] . '</td>
                            <td>' . $queryrow['q_des'] . '</td>
                            <td> <a href="'.$selfpath.'?delfeed='.$queryrow['q_id'].'"  type="button"  class="btn btn-danger  btn-sm mx-1"><i class="bi bi-trash"></i></a></td><tr>';

                        
                    }
                    echo '</tbody>
                   </table>
            </div>
        </div>
        </div>
    </div>

    ';


?>