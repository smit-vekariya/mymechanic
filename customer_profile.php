<?php
session_start();
?>
<?php
include 'partials\_dbconnect.php';
$alerterror = false;
$alertsuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_GET['user'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $customerzip = $_POST['customerzip'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $passquery = "SELECT  `c_password` FROM `customer` WHERE `c_email` = '$user'";
    $passresult = mysqli_query($conn, $passquery);
    $passrow = mysqli_fetch_assoc($passresult);

        // Form validations------------------------------------------------------------------------------------------------
        $namevalid =  false;
        $passwordvalid = false;
        $imagevalid = false;
        //name validation=================
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
            $namevalid = true;
        }
        //name validation=================
        if (!password_verify($password, $passrow['c_password'])) {
            $passwordvalid = true;
        }
        // Form validations End-------------------------------------------------------------------------------------

    $sql2 = "";
    if (($_FILES['customerphoto']['tmp_name']) != "") {
        $customerphoto = addslashes(file_get_contents($_FILES['customerphoto']['tmp_name']));
        $sql2 = "UPDATE `customer` SET `c_name` = '$fullname', `c_adress` = '$address', `c_photo` = '$customerphoto', `c_zipcode` = '$customerzip', `c_city` = '$city',  `c_phone` = '$phone' WHERE `customer`.`c_email` = '$user'";
       
        //Image validation
        
        $allowed_image_extension = array("png", "jpg", "jpeg");
        $file_extension = pathinfo($_FILES["customerphoto"]["name"], PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["customerphoto"]["size"] > 1000000)) {
            $imagevalid = true;
        }
    } else {
        $sql2 = "UPDATE `customer` SET `c_name` = '$fullname', `c_adress` = '$address',`c_zipcode` = '$customerzip', `c_city` = '$city',  `c_phone` = '$phone' WHERE `customer`.`c_email` = '$user'";
    }




    if($passwordvalid == false){
        if ( $namevalid == true || $imagevalid == true) {
            if( $namevalid == true){
                $alerterror ='<br>- Please Enter Valid User name, it containe only letters ';
            }
            if( $imagevalid == true){
                $alerterror .= '<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB';
            }
        }
        else{
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                $alertsuccess = "Profile updated successfully!!";
            } else {
                $alerterror = "we are facing some problems try after some time!!";
            }
        }
    }else{
        $alerterror = "Please Enter valid password!!";
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
<style>
    #customer-update1 {
        display: none;
    }

    #customer-update2 {
        display: block;
    }

    #updatepassword {
        display: none;
    }
</style>

<body>
    <!-- include navbar start -->
    <?php include 'partials\_navbar.php'; ?>
    <!-- include navbar End -->
    <!-- database connect start -->
    <?php include 'partials\_dbconnect.php'; ?>
    <!-- database connect End -->
    <?php
    $user = $_GET['user'];
    $sql1 = "SELECT *FROM `customer` WHERE c_email = '$user' ";
    $result1 = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($result1);
    $customerphoto = base64_encode($row['c_photo']);
    $fullname = $row['c_name'];
    $address = $row['c_adress'];
    $city = $row['c_city'];
    $email = $row['c_email'];
    $phone = $row['c_phone'];
    $customerzip = $row['c_zipcode'];
    ?>

    <!-- service Heading Start -->
    <div class="page-header" style="margin-bottom: 5px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>User Profile <i class="bi bi-file-person-fill"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->

    <!-- alert messahe from update start -->
    <?php
    if ($alerterror)
        echo '<div class="alert alert-danger alert-dismissible fade show mx-2" role="alert">
<i class="bi bi-exclamation-triangle-fill" style="font-size:20px">  </i><strong>Sorry!! </strong>' . $alerterror . '
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    ?>
    <?php
    if ($alertsuccess)
        echo '<div class="alert alert-success alert-dismissible fade show mx-2" role="alert">
        <i class="bi bi-check-circle-fill"> </i><strong>Success!! </strong>' . $alertsuccess . '
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    ?>
    <!-- alert messahe from update end -->


    <div class="profile-container">
        <div class="profile-field-container">
            <form class="profile-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?user=' . $user; ?>" enctype="multipart/form-data">
                <div id="customerphoto">
                    <label for="file-input">
                        <img src="data:image/jpg;base64,<?php echo $customerphoto ?>" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change Profile Photo">
                    </label>
                    <input id="file-input" name="customerphoto" type="file" />
                    <h2 class="form-field" style="font-weight: bold; color:white"><?php echo $fullname ?></h2>
                </div>
                <hr>
                <div class="profile-field mb-3">
                    <div class="mx-2">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Name :</p>
                        <input type="text" maxlength="30" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname ?>" required="required" />
                    </div>
                </div>


                <hr style="height:4px; background-color: white;">

                <!-- state and city -->
                <div class="profile-field-merge mb-3">
                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Zip Code :</p>
                        <input type="text" maxlength="6" class="form-control" id="customerzip" pattern="[0-9]{6}" oninvalid="this.setCustomValidity('Zip Code must be 6 digits')" onchange="this.setCustomValidity('')" name="customerzip" value=<?php echo $customerzip ?> />
                    </div>

                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> City :</p>
                        <select class="form-select " id="city" name="city">
                            <option value="<?php echo $city ?>"><?php echo $city ?></option>
                            <?php
                            $city = "SELECT *FROM `city`";
                            $cityresult = mysqli_query($conn, $city);
                            while ($cityrow = mysqli_fetch_assoc($cityresult)) {
                                $cityname = $cityrow['city_name'];
                                echo '<option value="' . $cityname . '">' . $cityname . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Email phone address -->
                <div class="profile-field-merge mb-3">
                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Email :</p>
                        <input type="email" maxlength="50" class="form-control mx-1" id="email" name="email" disabled value="<?php echo $email ?>" required="required" />
                    </div>
                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Phone Number :</p>
                        <input type="text" maxlength="10" class="form-control mx-1" id="phone" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('mobile number must be  10 digits')" onchange="this.setCustomValidity('')" name="phone" value="<?php echo $phone ?>" required="required" />
                    </div>
                </div>
                <div class="form-field mb-3 ">
                    <div class="mx-2">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Adrress :</p>
                        <textarea class="form-control" rows="2" maxlength="50" id="address" name="address" required="required"><?php echo $address ?></textarea>
                    </div>
                </div>


                <hr style="height:4px; background-color: white;">

                <!-- password and buttons -->
                <div class="form-field mb-3">
                    <input type="password" maxlength="30" class="form-control" id="updatepassword" name="password" placeholder="Enter Password" required="required" />
                </div>

                <div class="profile-button-container">
                    <button type="submit" class="customer-update mb-1" id="customer-update1">Submit</button>
                    <button class="customer-update mb-1" id="customer-update2" data-bs-toggle="modal" data-bs-target="#updateask">Update</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Update aks modal start-->
    <div class="modal fade" id="updateask" tabindex="-1" aria-labelledby="updateaskLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div style="border-radius: 25px; background-color: white" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 style="text-align: center"><strong>Do you really want to update your profile?</strong></h3>
                </div>
                <div style="margin:auto" class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="visible()">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Update aks modal End-->
    <script>
        function visible() {
            document.getElementById('customer-update1').style = 'display:block';
            document.getElementById('updatepassword').style = 'display:block';
            document.getElementById('customer-update2').style = 'display:none';
        }
    </script>















    <!-- Footer Start -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>

</html>