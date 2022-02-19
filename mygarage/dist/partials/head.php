<?php
include '_dbconnect.php';
echo '<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
<!-- Navbar Brand-->';
if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
$gr_id = $_SESSION['userid'];
$grstatus = "SELECT *FROM `garages` WHERE `gr_id` = $gr_id";
$grresult = mysqli_query($conn,$grstatus);
$grrow = mysqli_fetch_assoc($grresult);
$num = mysqli_num_rows($grresult);
if( $num>0 && $grrow['gr_status'] == 'approved'){
    echo '<a class="navbar-brand ps-3" href="index.php">Garage Owner <i class="bi bi-check-circle-fill" style="color:green"></i></a>';

}
else{
    echo '<a class="navbar-brand ps-3" href="index.php">Garage Owner</a>';
}

}



echo '<!-- Sidebar Toggle-->
<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
<!-- Navbar Search-->
<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <div class="input-group">
        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
    </div>
</form>
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
                <a class="nav-link" href="mygarage.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-gear-fill"></i></div>
                    My Garage
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
                
               
                <div class="sb-sidenav-menu-heading">Users Data</div>
                
                
                
            </div>
        </div>
        <div class="sb-sidenav-footer">';
        if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true && ($_SESSION['usertype'] == 'garageowner')) {
        $garageemial = $_SESSION['email'];
        $garagedata = "SELECT *FROM `garage_owner` WHERE `g_email` = '$garageemial' ";
        $garageresult = mysqli_query($conn, $garagedata);
        $garagerow = mysqli_fetch_assoc($garageresult);
        $garage_Owner_photo = "data:image/jpg;base64," . base64_encode($garagerow['g_photo']);

        
        echo '
        <img src=' . $garage_Owner_photo . ' style="height: 40px; width:40px;" class="rounded-circle" ">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updateadmin">'.$garageemial.'</button>
        </div>';
        }
        else{
            header('location: http://localhost/final-project/MyMechanic/index.php');
        }
            echo'</nav>
        </div>';
?>
<?php
//admin update PHP Code
    $selfpath = $_SERVER['PHP_SELF'];
       echo  '<div class="modal fade" id="updateadmin" tabindex="-1" aria-labelledby="updateadmin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateadmin">Admin Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:rgb(241, 241, 241)">
                    <form method="POST"  class="customer-form" enctype="multipart/form-data">
                    <div id="catphoto">
                    <label>
                        <img src="' . $garage_Owner_photo . '"  class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change category Photo">
                    </label>
                    
                    </div>
                        <input type="text" maxlength="30" class="form-control my-1" id="uadminname" name="uadminname" value="'.$garagerow['g_owner_name'].'" placeholder="Enter Admin Name" required="required" />
                        <input type="email" maxlength="50" class="form-control my-3" id="uadminemail" name="uadminemail" value="'.$garagerow['g_email'].'" placeholder="Enter Admin E-Mail" required="required" />
                        

                        
                        <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#logoutask"> <i class="bi bi-box-arrow-right"></i>  Logout</button>
                        <a href="http://localhost/final-project/MyMechanic/index.php"  class="btn btn-secondary">Go to MyMechanic</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutask" tabindex="-1" aria-labelledby="logoutaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div style="border-radius: 25px; background-color: white" class="modal-content">
            <div class="modal-header">
            <a href="'.$selfpath.'" type="button" class="btn-close"  aria-label="Close"></a>
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
    ';

  
?>