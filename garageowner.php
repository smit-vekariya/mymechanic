<?php
session_start();
?>
<?php
// database connection start
include 'partials\_dbconnect.php';
// database connection End 
$alerterror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$fullname = $_POST['fullname'];
	$garagename = $_POST['garagename'];
	$garageaddress = $_POST['garageaddress'];
	$garagezip = $_POST['zipcode'];
	$garagecity = $_POST['garagecity'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$licenceno = $_POST['licenceno'];
	$Ownerphoto = addslashes(file_get_contents($_FILES['Ownerphoto']['tmp_name']));
	$password = $_POST['password'];
	$confirmpassword = $_POST['confirmpassword'];


	// Form validations---------------------------------------------------------------------------------------------
	$imagevalid = false;
	$namevalid =  false;
	$garagenamevalid = false;
	$passwordvalid = false;

	// image validation checking=============
	$allowed_image_extension = array("png","jpg","jpeg");
	$file_extension = pathinfo($_FILES["Ownerphoto"]["name"], PATHINFO_EXTENSION);
	if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["Ownerphoto"]["size"] > 1000000)) {
		$imagevalid = true;
	}

	//name validation=================
	if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
		$namevalid = true;
	}
	//garagename validation=================
	if (!preg_match("/^[a-zA-Z-' ]*$/", $garagename)) {
		$garagenamevalid = true;
	}
	
	//password pattern===================
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);
	if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
		$passwordvalid =true;
	}
	//form validatin End----------------------------------------------------------------------------------------------

	$sql1 = "SELECT *FROM `garage_owner` WHERE `g_email` = '$email' ";
	$result1 = mysqli_query($conn, $sql1);
	$num1 = mysqli_num_rows($result1);
	if ($num1 > 0) {
		$alerterror = "E-mail is already registred please try with another E-mail.";
	} else {
		if ($password == $confirmpassword) {		
			if ($imagevalid == true || $namevalid ==true || $garagenamevalid == true || $passwordvalid ==true) {
				if ($passwordvalid ==true) {
					$alerterror .= '<br>- Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
				}if ($namevalid ==true ) {
					$alerterror .= '<br>- User name should be only in letters';
				}
				if ($garagenamevalid ==true ) {
					$alerterror .= '<br>- Garage Owner name should be only in letters';
				}
				if($imagevalid == true){
					$alerterror .='<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB';
				}
			} else {
				$hashpassword = password_hash($password, PASSWORD_DEFAULT);
				$sql2 = "INSERT INTO `garage_owner` (`g_owner_name`, `g_name`, `g_address`, `g_zipcode`,`g_city`, `g_email`, `g_phone`, `g_licence`, `g_photo`, `g_password`) VALUES ('$fullname', '$garagename ', '$garageaddress', '$garagezip','$garagecity', '$email', '$phone', '$licenceno','$Ownerphoto','$hashpassword')";
				$result2 = mysqli_query($conn, $sql2);
				if ($result2) {
					header("location: garage_login.php?signup=success");
				}
			}
		} else {
			$alerterror = "Confirm password can't match please enter same password in both section ";
		}
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
	<title>Garege Owner Login</title>
</head>

<body>
	<!-- include navbar start -->
	<?php include 'partials\_navbar.php'; ?>
	<!-- include navbar End -->
	<?php
	if ($alerterror)
		echo '<div class="alert alert-danger alert-dismissible fade show my-2 mx-2" role="alert">
<i class="bi bi-exclamation-triangle-fill" style="font-size:20px">  </i><strong>Sorry!! </strong>' . $alerterror . '
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
	?>
	<!-- garageowner form html start  -->
	<div class="form-container">
		<div class="field-container">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="customer-form" enctype="multipart/form-data">
				<h2 class="form-field" style="font-weight: bold; color:white">Garage Owner Form <i class="bi bi-card-checklist"></i> </h2>
				<hr>
				<div class="form-field mb-3">
					<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Garage Owner Name" maxlength="30" required="required" />
				</div>
				<div class="form-field mb-3">
					<input type="text" class="form-control" id="garagename" name="garagename" placeholder="Enter Garage Name" maxlength="50" required="required" />
				</div>


				<hr style="height:4px; background-color: white;">


				<div class="form-field-merge mb-3">
					<div class="mx-2" style="width:100%">
						<input type="text" maxlength="6" class="form-control" id="zipcode" pattern="[0-9]{6}" oninvalid="this.setCustomValidity('Zip code must be 6 digits')" onchange="this.setCustomValidity('')" name="zipcode" placeholder="Enter zip code" required="required" />
					</div>

					<div class="mx-2" style="width:100%">
						<select class="form-select " id="garagecity" name="garagecity">
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
				<div class="form-field-merge mb-3">
					<input type="email" class="form-control mx-2" id="email" pattern=".+@gmail\.com" oninvalid="this.setCustomValidity('Enter Valid Email it contains \'@\' or\'.\' ')" onchange="this.setCustomValidity('')"name="email" placeholder="Enter E-Mail" maxlength="50" required="required" />
					
					<input type="text" class="form-control" id="phone" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('mobile number must be 10 digits')" onchange="this.setCustomValidity('')"  name="phone" placeholder="Enter Phone Number" maxlength="10" required="required" />
				</div>
				<div class="form-field mb-3">
					<textarea class="form-control" id="garageaddress" name="garageaddress" placeholder="Enter Garage Adress" maxlength="50" required="required"></textarea>
				</div>


				<hr style=" background-color: white;">



				<div class="form-field-merge mb-3">
					<div class="mx-4">
						<p style="margin-bottom: 0px; font-size: 14px; color: white;">Garage Licence Number :</p>
						<input type="text" class="form-control" id="licenceno" name="licenceno" placeholder=" Licence Number" maxlength="20" required="required" />
					</div>

					<div>
						<p style="margin-bottom: 0px; font-size: 14px; color: white;">Garage Owner photo :</p>
						<input type="file" class="form-control" id="Ownerphoto" name="Ownerphoto" required="required" />
					</div>
				</div>


				<hr style="height:4px; background-color: white;">


				<div class="form-field mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" maxlength="30" required="required" />
				</div>
				<div class="form-field mb-3 ">
					<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" maxlength="30" placeholder="Confirm Password" required="required" />
				</div>
				<div class="form-field mb-3">
					<input type="checkbox" class="form-check-input mx-1" id="checkterms" required="required" oninvalid="this.setCustomValidity('Please accept Terms&Condition')" onchange="this.setCustomValidity('')" />
					<label class="form-check-label text-light" for="exampleCheck1">Read and accept all <a class="text-primary" href="t&c.php">Terms and Condition.</a></label>
				</div>
				<div class="button-container">
					<button class="customer-submit mb-1 " type="submit">Submit</button>
					<button class="customer-submit mb-1 " type="reset">Reset</button>
				</div>

			</form>
		</div>
	</div>
	<!-- garageowner form html start  -->





	<!-- Footer End -->
	<?php include 'partials/_footer.php'; ?>
	<!-- Footer End -->
	<script src="MYMECHANIC_JS/mechanic.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>