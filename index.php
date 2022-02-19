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


    <!-- css liabraries start-->
    <!-- css liabraries End-->
    <title>MyMechanic</title>

</head>
<body>
<!-- include navbar start -->   
<?php include 'partials\_navbar.php';?>
<!-- include navbar End -->
<!-- include navbar start -->   
<?php include 'partials\_dbconnect.php';?>
<!-- include navbar End -->
<?php
if(isset($_GET['login']) && ($_GET['login'])== 'success'){
    echo '<div class="alert alert-success alert-dismissible fade show my-2 mx-2" role="alert">
    <i class="bi bi-check-circle-fill"> </i><strong>Congratulations!! </strong>
You are logged in successfully!!
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<audio controls autoplay style="display:none">
  <source src="images/horn.mp3" type="audio/ogg">
  <source src="images/horn.mp3" type="audio/mpeg">
</audio>

';
}
?>

    <!-- carausal start -->
    <div id="carouselExampleCaptions" style="z-index: -1;" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/back1.jpg" style="opacity: 0.89;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 style="font-size: 100px; font-weight:700; text-shadow: 5px 5px 9px black;">Keep Your Car Newer</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/back2.jpg" style="opacity: 0.89;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 style="font-size: 100px; font-weight:700; text-shadow: 5px 5px 9px black;">Quality Service For You</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/back3.jpg" style="opacity: 0.89;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 style="font-size: 100px; font-weight:700; text-shadow: 5px 5px 9px black;">Service Before You Sleep</h1>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- carausal end -->


    <!-- About card strip_tags -->
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
    <!-- About card End -->


    <!-- popular services start -->
    <div class="service">
        <div class="container">
            <div class="section-header text-center">
                <p>What We Do?</p>
                <h2>Popular Categories</h2>
            </div>
            <div class="row">
            <?php
                $sql1 = "SELECT *FROM `category` WHERE `cat_status`= 'Active' AND `cat_by` = 'mymechanic' LIMIT 4";
                $result1 = mysqli_query($conn, $sql1);
                while($row1 = mysqli_fetch_assoc($result1)){
                    $catimage = "data:image/jpg;base64," . base64_encode($row1['cat_image']);
                    $catname = $row1['cat_name'];
                    $catdes = $row1['cat_description'];

                    echo '<div class="col-lg-3 col-md-6">
                        <div class="service-item">
                        <img src='.$catimage.'>
                        <h3>'.$catname.'</h3>
                        <p>'.$catdes.'</p>
                        <a href="category.php" type="button" class="btn btn-secondary mt-2">View All Categories</a>
                        </div>
                        </div>';
                }
                ?>
                
            </div>
        </div>
    </div>
    <!-- popular services End -->


    <!-- customer reviews Start -->
    <div class="testimonial">
        <div class="container">
            <div class="section-header text-center">
                <p>Reviews</p>
                <h2>What our customer say</h2>
            </div>
            <div class="owl-carousel testimonials-carousel">
                <div class="testimonial-item">
                    <img src="images/customer1.JPG" alt="Image">
                    <div class="testimonial-text">
                        <h3>Haresh Padshala</h3>
                        <h4>Profession</h4>
                        <p><i class="bi bi-patch-check-fill" style="font-size: 1.5rem; color: #cc1a2c;"></i>
                        Booking an online car service is a hassle when going for an authorized service center. So I use the Mymechanic web to book car services Very smooth process!
                        </p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img src="images/customer2.JPG" alt="Image">
                    <div class="testimonial-text">
                        <h3>Brijesh Choudhary</h3>
                        <h4>Profession</h4>
                        <p><i class="bi bi-patch-check-fill" style="font-size: 1.5rem; color:  #cc1a2c;"></i>
                        Getting your car serviced at regular intervals is very crucial and GoMyMechanic’s app makes it even easier to book your car services.this is really great
                        </p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img src="images/customer3.JPG" alt="Image">
                    <div class="testimonial-text">
                        <h3>Kishan Padshala</h3>
                        <h4>Profession</h4>
                        <p><i class="bi bi-patch-check-fill" style="font-size: 1.5rem; color: #cc1a2c;"></i>
                        Comprehensive package at Mymechanic was really a good choice. I book it after every 200k kms and my car is thoroughly inspected and fixed for any problems every time!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- customer reviews end -->

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
    <?php include 'partials/_footer.php';?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>

</body>

</html>