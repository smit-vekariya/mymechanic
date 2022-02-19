<?php
session_start();
?>
<?php
//  database connection start
include 'partials\_dbconnect.php';
//  database connection End 
$alerterror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql1 = "SELECT *FROM `garage_owner` WHERE g_email = '$email' ";
    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);

    if ($num1 == 1) {

        $row = mysqli_fetch_assoc($result1);
        if (password_verify($password, $row['g_password'])) {
            session_start();
            $_SESSION['userid'] = $row['g_id'];
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'garageowner';
            header("location: index.php?login=success");
        } else {
            $alerterror = "Please Enter valid password!!";
        }
    } else {

        $alerterror = "Account Does not Exist!! Please Create Your Account first";
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
    <?php
    if (isset($_GET['signup']) && ($_GET['signup']) == 'success') {
        echo '<div class="alert alert-success alert-dismissible fade show my-2 mx-2" role="alert">
    <i class="bi bi-check-circle-fill"> </i><strong>Congratulations!! </strong>
You are signed up successfully now you can login your Account!!
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    ?>
    <!-- customer form html start  -->
    <div class="form-container">
        <div class="field-container">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="customer-form">
                <h2 class="form-field" style="font-weight: bold; color:white"> Garage Owner Login <i class="bi bi-card-checklist"></i></h2>
                <hr>
                <div class="form-field mb-3">
                    <input type="email" maxlength="50" class="form-control" id="email" name="email"   oninvalid="this.setCustomValidity('Enter Valid Email it contains \'@\' or \'.\' ')" onchange="this.setCustomValidity('')" pattern=".+@gmail\.com" placeholder="Enter E-Mail" required="required" />
                </div>

                <hr style="height:4px; background-color: white;">

                <div class="form-field mb-3">
                    <input type="password" maxlength="30" class="form-control" id="password" name="password" placeholder="Enter Password" required="required" />
                </div>
                <div class="button-container">
                    <button class="customer-submit mb-1 " type="submit">Submit</button>
                    <button class="customer-submit mb-1 " type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <!-- customer form html End  -->











    <!-- Footer End -->
    <?php include 'partials/_footer.php'; ?>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="MYMECHANIC_JS/mechanic.js"></script>
</body>

</html>