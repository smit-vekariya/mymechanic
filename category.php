<?php
session_start();
?>
<?php
include 'partials\_dbconnect.php';

if (isset($_GET['garageid'])) {
    $grid = $_GET['garageid'];
    $gdata = "SELECT *FROM `garages` INNER JOIN `garage_owner` ON garages.gr_id=garage_owner.g_id WHERE `gr_id` = $grid";
    $gdataresult = mysqli_query($conn, $gdata);
    $grrown = mysqli_fetch_assoc($gdataresult);
    $grlphoto =  "data:image/jpg;base64," . base64_encode($grrown['grl_photo']);

    $grname = $grrown['g_name'];
    $groname = $grrown['g_owner_name'];
    $graddress = $grrown['g_address'];
    $grzip = $grrown['g_zipcode'];
    $grcity = $grrown['g_city'];
    $gremail = $grrown['g_email'];
    $grphone = $grrown['g_phone'];
    $grabout = $grrown['gr_About'];
    $grspecial1 = $grrown['gr_special1'];
    $grspecial2 = $grrown['gr_special2'];
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
<style>
    .garage-body {
        content: "";
        position: absolute;
        z-index: -1;
        opacity: 0.9;
        background: linear-gradient(rgba(0, 0, 0, 0.61), rgba(0, 0, 0, 0.596)), url(<?php echo $grlphoto ?>)no-repeat center center/cover;
        width: 100%;
        height: 350px;
        overflow: auto;
    }
</style>


<body>
    <!-- include navbar start -->
    <?php include 'partials\_navbar.php'; ?>
    <!-- include navbar End -->


    <?php
    if (isset($_GET['garageid'])) {
        echo '<!-- service Heading Start -->
    <div class="page-header " style="padding: 20px 0px; margin-bottom:5px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>'.$grname.' <i class="bi bi-gear-fill"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->';

        echo '<div class="card mx-2 my-1  garage-label">
        <div class="garage-card-header">
            <h6 class="my-1 px-3"><i class="bi bi-person-fill"></i> ' . $groname . ' </h6>
            <p class="px-1 my-1"><i style="color:rgb(204, 0, 0)" class="bi bi-phone-fill"></i>+91' . $grphone . '</p>
            <p class="px-1 my-1"><i style="color:green" class="bi bi-envelope-fill"></i> ' . $gremail . '</p>
        </div>
        <div class="card-body text-light garage-body mt-5 ">
            <h5 class="card-title mt-5" style="color:rgb(0, 177, 0)"><i class="bi bi-geo-alt-fill"></i>
                Garage Address</h5>
            <p class="card-text">' . $grcity . '-' . $grzip . '<br>' . $graddress . '</p>
            <h5 class="card-title mt-4" style="color:rgb(0, 177, 0)"><i class="bi bi-question-circle-fill"></i> About Us
            </h5>
            <p class="card-text">' . $grabout . '</p>
            <h5 class="card-title mt-4" style="color:rgb(0, 177, 0)"><i class="bi bi-tools"></i> Popular
                Categories</h5>
            <p style="margin-bottom: 1px;"><i class="bi bi-check-circle" style="color:red"></i> ' . $grspecial1 . '</p>
            <p style="margin-bottom: 1px;"><i class="bi bi-check-circle" style="color:red"></i> ' . $grspecial2 . '</p>
        </div>
    </div>';
    } else {

        echo '<!-- service Heading Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Select Category <i class="bi bi-tools"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->';
    }
    ?>



    <?php
    if (isset($_GET['garageid'])) {
        echo '<div class="service" style="margin-top: 400px;">
        <div class="container">
        <div class="section-header text-center">
        <h2>Select Categories</h2>
        <p class="my-2">As Your requirement</p>
        </div>
        <div class="row">';
        $sql1 = "SELECT *FROM `category` WHERE `cat_status`= 'Active' AND `cat_by` = '$grid'";
        $result1 = mysqli_query($conn, $sql1);  
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $catimage = "data:image/jpg;base64," . base64_encode($row1['cat_image']);
            $catid = $row1['cat_id'];
            $catname = $row1['cat_name'];
            $catdes = $row1['cat_description'];

            echo ' 
                        <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                        <img src=' . $catimage . '>
                        <h3>' . $catname . '</h3>
                        <p>' . $catdes . '</p>
                        <a href="service.php?cat_id=' . $catid . '" type="button" class="btn btn-secondary mt-2">Select Category</a>
                        </div>
                        </div>';
        }
    } else {
        echo '<div class="service">
        <div class="container">
            <div class="section-header text-center">
                <h2>Select Categories</h2>
                <p class="my-2">As Your requirement</p>
            </div>
            <div class="row">';

        $sql1 = "SELECT *FROM `category` WHERE `cat_status`= 'Active' AND `cat_by` = 'mymechanic'";
        $result1 = mysqli_query($conn, $sql1);

        while ($row1 = mysqli_fetch_assoc($result1)) {
            $catimage = "data:image/jpg;base64," . base64_encode($row1['cat_image']);
            $catid = $row1['cat_id'];
            $catname = $row1['cat_name'];
            $catdes = $row1['cat_description'];

            echo '
                        <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                        <img src=' . $catimage . '>
                        <h3>' . $catname . '</h3>
                        <p>' . $catdes . '</p>
                        <a href="service.php?cat_id=' . $catid . '" type="button" class="btn btn-secondary mt-2">Select Category</a>
                        </div>
                        </div>';
        }
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