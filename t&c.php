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

    <!-- About Heading Start -->
    <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Terms & Condition <i class="bi bi-exclamation-diamond-fill"></i></h2>
                    </div>
                   
                </div>
            </div>
        </div>
    <!-- About Heading End -->

    <!-- About Section start -->
    <div class="about">
        <div class="container">
            <div class="row align-items-center">
               
                <div class="col-lg-10">
                    <div class="section-header text-left">
                        <p>Terms & Condition</p>
                        <h2>CONTRACTUAL RELATIONSHIP</h2>
                    </div>
                    <div class="about-content">
                        <p style="text-align: justify">
                        Targetone Innovations Private Limited, incorporated under the Companies Act, 2013, having its registered office at Shop No. 8, Ramesh Market, Dayanand Colony, Lajpat Nagar, New Delhi – 110024, operating under the trademarked name “GoMechanic”, provides holistic car services including maintenance, repair, etc. The use and access of our website www.gomechanic.in (“Website”), and our mobile applications “GoMechanic - Car Services, Battery & Tyre” (“Applications”), or any products or services in connection with the Application or Website (“Services”) shall be governed by these terms and conditions (“Terms”). The Website and Applications are together called the “Platform”.
                        </p>
                        <h2>USE OF SERVICES</h2>
                        <p style="text-align: justify">You must create an account in order to use some of the features offered by the Platform. Use of any personal information you provide to us during the account creation process is governed by our Privacy Policy available on our app/website. You must keep your password confidential and you are solely responsible for maintaining the confidentiality and security of your account details, all changes and updates submitted through your account, and all activities that occur in connection with your account.
Following sign-up, we will make certain Services available to you free of charge. The Services will include the ability to search for service providers for automotive repair or servicing work, the ability to view detailed profiles of service providers and their service prices and rating information, and the ability to post feedback and ratings in relation to any service provider you have used as a result of your use of the Platform. We reserve the right to add, change or remove Services from our Platform at any time, and may make certain Services chargeable at our discretion.</p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i>Make sure you read all terms and condition</li>
                            <li><i class="bi bi-check-circle"></i>If any query contect us</li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section start -->

    
 


    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>