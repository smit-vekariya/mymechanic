<?php
// admin adding php code start
session_start();
$alerterror = false;
$alertsuccess = false;
include 'partials/_dbconnect.php';

if(isset($_GET['approve'])){
    $grid = $_GET['approve'];
    $appsql = "SELECT *FROM `garages` WHERE  `gr_id` = '$grid'";
    $appresult = mysqli_query($conn,$appsql);
    $approw = mysqli_fetch_assoc($appresult);
    $num1 = mysqli_num_rows($appresult);
    if($approw['gr_status'] == 'requested' || $approw['gr_status'] == 'disapproved'){
        $approvequery = "UPDATE `garages` SET `gr_status` = 'approved' WHERE `gr_id` = '$grid'";
    }
    else{
        $approvequery = "UPDATE `garages` SET `gr_status` = 'disapproved' WHERE `gr_id` = '$grid'";
    }
    $approveresult = mysqli_query($conn,$approvequery);
    if($approvequery){
        header('location: approve.php');
    }
    else{
        die(mysqli_error($conn));
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
    #catphoto{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
    #catphoto div{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 5px;

    }
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
                <h1 class="mt-4"><i class="bi bi-check-circle-fill"></i> Garage Approvement</h1>
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
                <!-- Alert messages  -->








                <?php
                if (isset($_GET['viewgarage'])) {
                    $grid = $_GET['viewgarage'];

                    $gdata = "SELECT *FROM `garages` INNER JOIN `garage_owner` ON garages.gr_id=garage_owner.g_id WHERE `gr_id` = $grid";
                    $gdataresult = mysqli_query($conn, $gdata);

                    while ($grrown = mysqli_fetch_assoc($gdataresult)) {
                        $grname = $grrown['g_name'];
                        $groname = $grrown['g_owner_name'];
                        $graddress = $grrown['g_address'];
                        $grzip = $grrown['g_zipcode'];
                        $grcity = $grrown['g_city'];
                        $gremial = $grrown['g_email'];
                        $grphone = $grrown['g_phone'];
                        $grlicence = $grrown['g_licence'];
                        $grophoto = "data:image/jpg;base64," . base64_encode($grrown['g_photo']);
                        $grreg = $grrown['g_registrationdate'];
                        $grabout = $grrown['gr_About'];
                        $grlphoto =  "data:image/jpg;base64," . base64_encode($grrown['grl_photo']);
                        $grspecial1 = $grrown['gr_special1'];
                        $grspecial2 = $grrown['gr_special2'];
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

                    <div class="modal fade" id="updatecat" tabindex="-1" aria-labelledby="updatecat" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content" style=" border:none; border-radius: 20px;">

                            <div class="modal-header">
                                <h5 class="modal-title" id="bookmark">'.$grname.'</h5>
                                <a href="approve.php" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                            </div>
                            <div class="modal-body" id="">
                            <div id="catphoto">
                            <div>
                                <label for="updateser_img">
                                    <img src="' . $grophoto . '" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change Service Photo">
                                </label>
                                <label for="updateser_img" style="cursor: pointer">
                                    <h6>Owner Photo</h6>
                                </label>
                                </div>
                                <div>
                                <label for="updateser_img">
                                    <img style="float:left;" src="' . $grlphoto . '" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change Service Photo">
                                </label>
                                <label for="updateser_img" style="cursor: pointer">
                                    <h6>Label Photo</h6>
                                    </div>
                                </label>
                            </div>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage Name :</p>
                            <input type="text"  class="form-control my-1" value="'.$grname.'" disabled>
                            
                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Owner Name:</p>
                            <input type="text"  class="form-control my-1" value="'.$groname.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Owner E-mail :</p>
                            <input type="text"  class="form-control my-1" value="'.$gremial.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Owner Phone:</p>
                            <input type="text"  class="form-control my-1" value="'.$grphone.'" disabled>                   

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage City:</p>
                            <input type="text"  class="form-control my-1" value="'.$grcity.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage Zipcode:</p>
                            <input type="text"  class="form-control my-1" value="'.$grzip.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage Address:</p>
                            <input type="text"  class="form-control my-1" value="'.$graddress.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage Licence No :</p>
                            <input type="text"  class="form-control my-1" value="'.$grlicence.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage Reg. Date :</p>
                            <input type="text"  class="form-control my-1" value="'.$grreg.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Garage About :</p>
                            <input type="text"  class="form-control my-1" value="'.$grabout.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Category 1 :</p>
                            <input type="text"  class="form-control my-1" value="'.$grspecial1.'" disabled>

                            <p style="margin-bottom: 0px; font-size: 14px; color: black;">Category 2:</p>
                            <input type="text"  class="form-control my-1" value="'.$grspecial2.'" disabled>
                  
                            </div>
                            <div class="modal-footer">
                            <a href="approve.php?approve='.$grid.'"  type="button" class="btn btn-success mx-1"><i class="bi bi-check-all"></i> Approve</a>

                                <a href="approve.php" type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</a>
                            </div>
                        </div>
                    </div>
                </div>';
                }
                ?>







                <!-- category table start  -->
                <div id="Admin">
                    <div class="card mb-4">
                        <div class="card-header" style="background-color:#f3f3f3;">
                            <i class="fas fa-table me-1"></i>
                            Garage Owner Approvel
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple6">
                                <thead>
                                    <tr class="table-dark">
                                        <th>Garage ID</th>
                                        <th>Garage Owner Name</th>
                                        <th>Garage Name</th>
                                        <th>Garage city</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Garage ID</th>
                                        <th>Garage Owner Name</th>
                                        <th>Garage Name</th>
                                        <th>Garage city</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $gdata = "SELECT *FROM `garages` INNER JOIN `garage_owner` ON garages.gr_id=garage_owner.g_id ";
                                    $gdataresult = mysqli_query($conn, $gdata);

                                    while ($gdatarow = mysqli_fetch_assoc($gdataresult)) {
                                        $grstatus = $gdatarow['gr_status'];
                                        echo ' <tr class="table-light" >
                                        <td>' . $gdatarow['gr_id'] . '</td>
                                        <td>' . $gdatarow['g_owner_name'] . '</td>
                                        <td>' . $gdatarow['g_name'] . '</td>
                                        <td>' . $gdatarow['g_city'] . '</td>
                                        <td>
                                        <div id="catbuttons">
                                        
                                        <a href="approve.php?viewgarage=' . $gdatarow['gr_id'] . '"  type="button" class="btn btn-warning  btn-sm mx-1"><i class="bi bi-eye-fill"></i> View</a>';
                                        if($grstatus == 'requested' ||  $grstatus == 'disapproved')
                                        {
                                        echo '<a href="approve.php?approve=' . $gdatarow['gr_id'] . '"  type="button" class="btn btn-success  btn-sm mx-1"><i class="bi bi-check-all"></i> Approve</a>';
                                        }
                                        else{
                                            echo '<a href="approve.php?approve=' . $gdatarow['gr_id'] . '"  type="button" class="btn btn-danger  btn-sm mx-1"><i class="bi bi-slash-circle"></i> Dispprove</a>';
                                        }
                                       
                                        echo'</div>
                                        
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


    <!-- including foot start  -->
    <?php include 'partials/foot.php'; ?>
    <!-- including foot start  -->

</body>

</html>