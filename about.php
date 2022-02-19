<?php
session_start();
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
                    <h2>About Us <i class="bi bi-phone-vibrate"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->

        <!-- About Section start -->
        <div class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img">
                        <img src="images/about1.jpg" alt="Image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-header text-left">
                        <p>About Us</p>
                        <h2>We are providing Online Booking system for Car Service.</h2>
                    </div>
                    <div class="about-content">
                        <p>
                        MyMechanic is a network of technology-enabled car service centres, offering a seamless car service experience at the convenience of a tap. With our highly skilled technicians, manufacturer recommended procedures and the promise of genuine spare parts we are your best bet.
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i>Best Service</li>
                            <li><i class="bi bi-check-circle"></i>Best Pricing</li>
                            <li><i class="bi bi-check-circle"></i>Value For Time</li>
                            <li><i class="bi bi-check-circle"></i>Trustable Plateform</li>
                        </ul>
                        <a href="category.php" type="button" class="btn btn-secondary">View Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section start -->

    <!-- Facts Start -->
    <div class="facts">
        <div class="container">
            <div class="section-header text-center">
                <p>Facts</p>
                <h2>About Our Successful Journy</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div class="facts-text">
                            <h3>500</h3>
                            <p>Garages</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="bi bi-person-fill"></i>
                        <div class="facts-text">
                            <h3>1500</h3>
                            <p>Engineers & Workers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="bi bi-people-fill"></i>
                        <div class="facts-text">
                            <h3>900</h3>
                            <p>Satisfied Customers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="bi bi-check-all"></i>
                        <div class="facts-text">
                            <h3>2000</h3>
                            <p>Service Booked per Month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Facts End -->


    
 


    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>