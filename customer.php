<?php
session_start();
?>
<?php
// including database 
include 'partials\_dbconnect.php';
// including database 

$alerterror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$fullname = $_POST['fullname'];
	$address = $_POST['address'];
	$customerphoto = addslashes(file_get_contents($_FILES['customerphoto']['tmp_name']));
	$customerzip = $_POST['zipcode'];
	$city = $_POST['city'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$confirmpassword = $_POST['confirmpassword'];

	// Form validations---------------------------------------------------------------------------------------------
	$imagevalid = false;
	$namevalid =  false;
	$passwordvalid = false;

	// image validation checking=============
	$allowed_image_extension = array("png","jpg","jpeg");
	$file_extension = pathinfo($_FILES["customerphoto"]["name"], PATHINFO_EXTENSION);
	if (!in_array($file_extension, $allowed_image_extension) || ($_FILES["customerphoto"]["size"] > 1000000)) {
		$imagevalid = true;
	}

	//name validation=================
	if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
		$namevalid = true;
	}
	
	//password pattern===================
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);
	if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
		$passwordvalid =true;
	}
	// Form validations End-------------------------------------------------------------------------------------

	$sql1 = "SELECT *FROM `customer` WHERE `c_email` = '$email' ";
	$result1 = mysqli_query($conn, $sql1);
	$num1 = mysqli_num_rows($result1);
	if ($num1 > 0) {
		$alerterror = "E-mail is already registred please try with another E-mail.";
	} else {
		if ($password == $confirmpassword) {
			
			if ($imagevalid == true || $namevalid == true || $passwordvalid == true) {
				if ($passwordvalid == true ) {
					$alerterror .= '<br>- Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
				}
				if($namevalid == true){
					$alerterror .='<br>- Please Enter Valid User name, it containe only letters';
				}
				if ($imagevalid == true) {
					$alerterror .= '<br>- Upload valiid images. Only PNG,JPG and JPEG are allowed and file size should be less then 1 MB';
				}
				
			} else {
				$hashpassword = password_hash($password, PASSWORD_DEFAULT);
				$sql2 = "INSERT INTO `customer` (`c_name`, `c_adress`,`c_photo`, `c_zipcode`,`c_city`, `c_email`, `c_phone`, `c_password`) VALUES ('$fullname', '$address', '$customerphoto', '$customerzip', '$city', '$email', '$phone', '$hashpassword')";
				$result2 = mysqli_query($conn, $sql2);
				if ($result2) {
					header("location: customer_login.php?signup=success");
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
	<title>Customer Login</title>
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
	<!-- customer form html start  -->
	<div class="form-container">
		<div class="field-container">
			<!-- <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="customer-form" enctype="multipart/form-data">
				<h2 class="form-field" style="font-weight: bold; color:white; text-align:center"> Customer Form <i class="bi bi-card-checklist"></i></h2>
				<hr style="height:4px; background-color: Red;">
				<p style="font-weight: bold; color:white">Enter Your Full Name: </p>
				<div class="form-field mb-3">
					<input type="text" maxlength="30" class="form-control" id="fullname" name="fullname" placeholder="Enter Name"required="required" />
				</div>
				<hr style="height:4px; background-color: white;">
				<div class="form-field-merge mb-3">
					<div class="mx-2" style="width:100%">
					<p style="font-weight: bold; color:white">Enter zip code</p>
						<input type="text" maxlength="6" class="form-control" pattern="[0-9]{6}" oninvalid="this.setCustomValidity('Zip Code must be 6 digits')" onchange="this.setCustomValidity('')" id="zipcode" name="zipcode" placeholder="Ex. 360 370" required="required" />
					</div>

					<div class="mx-2" style="width:100%">
					  <p style="font-weight: bold; color:white">Enter City Name:</p>
						<select class="form-select " id="city" name="city">
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
				<div>
				<div class="form-field-merge mb-3">
				 <div class="mx-2" style="width:100%">
				 <p style="font-weight: bold; color:white">Email:</p>
					<input type="email" maxlength="50" class="form-control mx-1" id="email"
					oninvalid="this.setCustomValidity('Enter Valid Email it contains \'@\' or \'.\' ')" onchange="this.setCustomValidity('')" pattern=".+@gmail\.com" name="email"  placeholder="Ex.abc@gmail.com" required="required" />
				 </div>
				 <div class="mx-2" style="width:100%">
					<p style="font-weight: bold; color:white">Mobile No:</p>
					<input type="text" maxlength="10" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('mobile number must be 10 digits')" onchange="this.setCustomValidity('')" class="form-control mx-1" id="phone" name="phone"  required="required" />
				 </div>
				</div>
				<div class="form-field-merge mb-3">
				
					<div class="mx-2" style="width:100%">
					<p style="font-weight: bold; color:white">Address :</p>
						<textarea class="form-control "  maxlength="50" id="address" name="address" required="required"></textarea>
					</div>
					<div class="mx-2" style="width:100%">
					<p style="font-weight: bold; color:white">Customer Photos:</p>
						<input type="file" class="form-control" id="customerphoto" name="customerphoto" required="required" />
					</div>
				</div>
				<hr style="height:4px; background-color: white;">
				<div class="form-field mb-3">
				<p style="font-weight: bold; color:white">Enter Password:</p>
					<input type="password" maxlength="30" class="form-control" id="password" name="password" required="required" />
				</div>
				<div class="form-field mb-3 ">
				
					<input type="password" maxlength="30" class="form-control" id="confirmpassword" name="confirmpassword"  required="required" />
				</div>
				<div class="form-field mb-3">
					<input type="checkbox" class="form-check-input mx-1" id="checkterms" required="required" oninvalid="this.setCustomValidity('Please accept Terms&Condition')" onchange="this.setCustomValidity('')" />
					<label class="form-check-label text-light" for="exampleCheck1">Read and accept all <a class="text-primary" href="t&c.php">Terms and Condition.</a></label>
				</div>
				<div class="button-container">
					<button class="customer-submit mb-1" type="submit">Submit</button>
					<button class="customer-submit mb-1" type="reset">Reset</button>
				</div>
			</form> -->
		</div>
	</div>
	<!-- customer form html End  -->

	<!-- Footer End -->
	<?php include 'partials/_footer.php'; ?>
	<!-- Footer End -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="MYMECHANIC_JS/mechanic.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>