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
    $garagename = $_POST['garagename'];
    $garageaddress = $_POST['garageaddress'];
    $garagezip = $_POST['garagezip'];
    $garagecity = $_POST['garagecity'];
    $phone = $_POST['phone'];
    $licenceno = $_POST['licenceno'];
    $password = $_POST['password'];


    $passquery = "SELECT  `g_password` FROM `garage_owner` WHERE `g_email` = '$user'";
    $passresult = mysqli_query($conn, $passquery);
    $passrow = mysqli_fetch_assoc($passresult);


    // Form validations---------------------------------------------------------------------------------------------
    $imagevalid = false;
    $namevalid =  false;
    $passwordvalid = false;
    $garagenamevalid = false;
    $sql2 = "";

    //name validation=================
    if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
        $namevalid = true;
    }
    //garagename validation=================
    if (!preg_match("/^[a-zA-Z-' ]*$/", $garagename)) {
        $garagenamevalid = true;
    }
    //password validation=================
    if (!password_verify($password, $passrow['g_password'])) {
        $passwordvalid = true;
    }

    //image validation checking==================
    if (($_FILES['ownerphoto']['tmp_name']) != "") {
        $Ownerphoto = addslashes(file_get_contents($_FILES['ownerphoto']['tmp_name']));
        $sql2 = " UPDATE `garage_owner` SET `g_owner_name` = '$fullname', `g_name` = '$garagename', `g_address` = '$garageaddress', `g_zipcode` = '$garagezip', `g_city` = '$garagecity', `g_phone` = '$phone', `g_licence` = '$licenceno',`g_photo`= '$Ownerphoto' WHERE `garage_owner`.`g_email` = '$user';";

        $allowed_image_extension = array("png", "jpg", "jpeg");
        $file_extension = pathinfo($_FILES["ownerphoto"]["name"], PATHINFO_EXTENSION);
        if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["ownerphoto"]["size"] > 1000000)) {
            $imagevalid = true;
        }
    } else {
        $sql2 = " UPDATE `garage_owner` SET `g_owner_name` = '$fullname', `g_name` = '$garagename', `g_address` = '$garageaddress', `g_zipcode` = '$garagezip', `g_city` = '$garagecity', `g_phone` = '$phone', `g_licence` = '$licenceno' WHERE `garage_owner`.`g_email` = '$user';";
    }


    if ($passwordvalid == false) {
        if($namevalid == true || $garagenamevalid == true || $imagevalid ==true){
            if($namevalid == true){
                $alerterror ='<br>- Please Enter Valid User name, it containe only letters';
            }
            if($garagenamevalid == true){
                $alerterror .= '<br>- Garage Owner name should be only in letters';

            }
            if($imagevalid ==true){
                $alerterror .='<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB';

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
    }
    else{
        $alerterror = "Please Enter Valid password";
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
    <!-- include navbar start -->
    <?php include 'partials\_dbconnect.php'; ?>
    <!-- include navbar End -->
    <!-- service Heading Start -->
    <div class="page-header" style="margin-bottom: 5px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>User Profile <i class="bi bi-file-person-fill"></i></h2>
                </div>

            </div>
        </div>
    </div>
    <!-- Service Heading End -->
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
    <?php
    $user = $_GET['user'];
    $sql1 = "SELECT *FROM `garage_owner` WHERE g_email = '$user' ";
    $result1 = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($result1);

    $fullname = $row['g_owner_name'];
    $garagename = $row['g_name'];
    $garageaddress = $row['g_address'];
    $garagecity = $row['g_city'];
    $email = $row['g_email'];
    $phone = $row['g_phone'];
    $licenceno = $row['g_licence'];
    $Ownerphoto = base64_encode($row['g_photo']);
    $garagezip = $row['g_zipcode'];
    ?>

    <div class="profile-container">
        <div class="profile-field-container">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?user=' . $user; ?>" class="profile-form" enctype="multipart/form-data">
                <div id="customerphoto">
                    <label for="file-input">
                        <img src="data:image/jpg;base64,<?php echo $Ownerphoto ?>" class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Change Profile Photo">
                    </label>
                    <input id="file-input" name="ownerphoto" type="file" />
                    <h2 class="form-field" style="font-weight: bold; color:white"><?php echo $fullname ?></h2>
                </div>
                <hr>
                <div class="form-field mb-3">
                    <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Garage Owner Name :</p>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname ?>" maxlength="30" required="required" />
                </div>
                <div class="form-field mb-3">
                    <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Garage Name :</p>
                    <input type="text" class="form-control" id="garagename" name="garagename" Value="<?php echo $garagename ?>" maxlength="50" required="required" />
                </div>


                <hr style="height:4px; background-color: white;">


                <div class="profile-field-merge mb-3">
                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Zip Code :</p>
                        <input type="text" maxlength="6" class="form-control" id="garagezip" pattern="[0-9]{6}" oninvalid="this.setCustomValidity('Zip Code must be 6 digits')" onchange="this.setCustomValidity('')" name="garagezip" value="<?php echo $garagezip ?>" required="required" />
                    </div>

                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;">Enter City :</p>
                        <select class="form-select " id="garagecity" name="garagecity">
                            <option selected value="<?php echo $garagecity ?>"><?php echo $garagecity ?></option>
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
                <div class="profile-field-merge mb-3">
                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> E-mail :</p>
                        <input type="email" class="form-control mx-1" id="email" name="email" value="<?php echo $email ?>" maxlength="50" disabled required="required" />
                    </div>
                    <div class="mx-2" style="width:100%">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;"> Phone Number :</p>
                        <input type="text" maxlength="10" class="form-control mx-1" id="phone" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('mobile number must be  10 digits')" onchange="this.setCustomValidity('')" name="phone" value="<?php echo $phone ?>" maxlength="10" required="required" />
                    </div>
                </div>
                <div class="form-field mb-3">
                    <p style="margin-bottom: 0px; font-size: 14px; color: white;">Address :</p>
                    <textarea class="form-control" id="garageaddress" name="garageaddress" maxlength="50" required="required"><?php echo $garageaddress ?></textarea>
                </div>


                <hr style=" background-color: white;">



                <div class="profile-field-merge mb-3">
                    <div class="mx-4">
                        <p style="margin-bottom: 0px; font-size: 14px; color: white;">Garage Licence Number :</p>
                        <input type="text" class="form-control" id="licenceno" name="licenceno" value="<?php echo $licenceno ?>" maxlength="20" required="required" />
                    </div>


                </div>


                <hr style="height:4px; background-color: white;">


                <div class="form-field mb-3">
                    <input type="password" class="form-control" id="updatepassword" name="password" placeholder="Enter Password" maxlength="30" required="required" />
                </div>

                <div class="profile-button-container">
                    <button type="submit" class="customer-update mb-1" id="customer-update1">Submit</button>
                    <button class="customer-update mb-1" id="customer-update2" data-bs-toggle="modal" data-bs-target="#updateask">Update</button>
                </div>

            </form>
        </div>
    </div>';





    <!-- Update aks modal start-->
    <div class="modal fade" id="updateask" tabindex="-1" aria-labelledby="updateaskLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div style="border-radius: 25px; background-color: white" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 style="text-align: center"><strong>Do you really update your profile?</strong></h2>
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