<?php
session_start();
?>
<?php
include 'partials\_dbconnect.php';
$alert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $q_name = $_POST['q_name'];
    $q_emial = $_POST['q_email'];
    $q_phone = $_POST['q_phone'];
    $q_type = $_POST['q_type'];
    $q_des = $_POST['q_des'];

    $querysql = "INSERT INTO `feedback` (`q_date`, `q_name`, `q_email`, `q_phone`, `q_type`, `q_des`) VALUES ( current_timestamp(), '$q_name', '$q_emial', '$q_phone', '$q_type', '$q_des')";
    $queryresult = mysqli_query($conn, $querysql);
    if ($queryresult) {
        $alert = true;
    } else {
        die(mysqli_error($conn));
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


    <!-- service Heading Start -->
    <div class="page-header" style="margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Contact Us <i class="bi bi-phone-vibrate"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->
    <?php
    if ($alert)
        echo '<div class="alert alert-success alert-dismissible fade show my-1 mx-1" role="alert">
<i class="bi bi-exclamation-triangle-fill" style="font-size:20px">  </i><strong>We got Your message!! </strong>
We will send you a responce if we find your query is important. Thank You!!
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';


    ?>

    <!-- contact us start -->
    <div class="location">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-header text-left">
                        <h2 style="color:black;">Our Head-Office & Customer Care</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="location-item">
                                <div class="location-text">
                                    <h3><i class="bi bi-building"></i> Head-Office</h3>
                                    <p><i class="bi bi-arrow-right-short"></i>201, gallerira Avenue</p>
                                    <p>Bapunagar, Ahmedabad-360008</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="location-item">
                                <div class="location-text">
                                    <h3><i class="bi bi-person-check-fill"></i> Customer Care</h3>
                                    <p><i class="bi bi-arrow-right-short"></i>501, Pramukh Avenue</p>
                                    <p>Navrangpura, Ahmedabad-360088</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="location-item">
                                <div class="location-text">
                                    <h3><i class="bi bi-telephone-forward-fill"></i> Contact Number</h3>
                                    <p><i class="bi bi-arrow-right-short"></i>+91 8905193172</p>
                                    <p><i class="bi bi-arrow-right-short"></i>+012 345 6789</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="location-item">
                                <div class="location-text">
                                    <h3><i class="bi bi-envelope"></i> E-Mail</h3>
                                    <p><i class="bi bi-arrow-right-short"></i>mymechanic@gmail.com</p>
                                    <p><i class="bi bi-arrow-right-short"></i>mymechanic.help.in</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="location-form">
                        <h3>Send Your Queries</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "post">
                            <div class="control-group">
                                <input type="text" class="form-control" maxlength="30" placeholder="Name" name="q_name" required="required" />
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control" maxlength="30" placeholder="Email" name="q_email" required="required" />
                            </div>
                            <div class="control-group">
                                <input type="text" maxlength="10" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('mobile number must be 10 digits')" onchange="this.setCustomValidity('') " class="form-control" placeholder="Phone" name="q_phone" required="required" />
                            </div>
                            <div class="control-group">
                                <select class="form-select" name="q_type" aria-label="Default select example">
                                    <option selected value="Customer">Customer</option>
                                    <option value="Garage Owner">Garage Owner</option>
                                    <option value="Visitor">Visitor</option>
                                </select>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control" maxlength="100" name="q_des" placeholder="Describe Your Queries" required="required"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-custom" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact us End -->






    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>