<?php
echo '
<div class="sticky-lg-top nav-container" style="z-index: 1">
  <nav class="navbar navbar-expand-lg navbar-light nav-background pb-0 pt-0 ">
    <div class="container-fluid ">

      <div class="p-1 my-container">
        <a class="border-0"  id="menu-btn">
          <img id="mainlogo" style="background-color: #cc1a2c; border-radius: 7px;" width="62" height="60" src="images/mechanic3.png">
        </a>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="me-auto mb-2 mb-lg-0 navbar-nav">
          <li class="nav-item">
            <a class="my-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="my-link" href="category.php">Services</a>
          </li>

          <li class="nav-item">
            <a class="my-link" href="garages.php">Garages</a>
          </li>

          <li class="nav-item">
            <a class="my-link" href="about.php">About us</a>
          </li>

          <li class="nav-item">
            <a class="my-link" href="contact.php">Contact us</a>
          </li>';
          if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
            if($_SESSION['usertype'] == 'garageowner'){
              echo '<li class="nav-item">
            <a class="my-link" style="color:white; background-color:#cc1a2c;" href="mygarage\dist\index.php"><i class="bi bi-gear-fill"></i> My Garage</a>
          </li>';
            }
          }

        echo '</ul>
        <!-- Appoitment button -->
        <div class="appoitment-button mx-1 my-2">
        <a href="category.php" type="button" class="btn btn-custom"><i class="bi bi-calendar2-date mx-3" style="font-size: 20px"></i>Get Appoitment</a>
        </div>';
        
        if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
          if($_SESSION['usertype'] == 'customer'){
            echo '
            <div class="  me-4 my-2">
            <button type="button" style="font-size: 23px" class="btn btn-warning rounded-circle" data-bs-toggle="modal" data-bs-target="#bookmark">
            <i class="bi bi-star-fill"></i>
            </button>
            <a href="order.php" type="button" style="font-size: 23px" class="btn btn-warning rounded-circle">
            <i class="bi bi-cart-check-fill"></i>
            </a>
            </div>';
          }         
        }

        if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true) {
          $user = $_SESSION['email'];
          if($_SESSION['usertype'] == 'customer'){
            echo '
          <a href="customer_profile.php?user='.$user.'" type="button" class="btn btn-dark my-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Profile">'. $_SESSION['email'].'</a>';
          }
          if($_SESSION['usertype'] == 'garageowner'){
            echo '
            <a href="garage_profile.php?user='.$user.'" type="button" class="btn btn-dark my-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Profile">'. $_SESSION['email'].'</a>';
          }
          if($_SESSION['usertype'] == 'admin'){
            echo '
          <a href="Myadmin\dist\index.php" type="button" class="btn btn-dark my-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Profile">'. $_SESSION['email'].'</a>';
          }
          echo '<button class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#logoutask">Logout</button>';
        }
       
        else { echo '
        <div class=" my-2">
          <button class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#loginask">Login</button>
          <button class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#signupask">Sign up</button>
        </div>';
      }
     echo' </div>
    </div>
  </nav>
</div>';

echo '
<div class="modal fade" id="signupask" tabindex="-1" aria-labelledby="signupaskLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div style="border-radius: 25px; background-color: white" class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <h2 style="text-align: center"><strong>How do you want to Sign up ?</strong></h2>
      </div>
      <div style="margin:auto" class="modal-footer">
      <a href="customer.php" class="btn btn-danger">As a Customer</a>
      <a href="garageowner.php" class="btn btn-danger">As a Garage Owner</a>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="loginask" tabindex="-1" aria-labelledby="loginaskLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div style="border-radius: 25px; background-color: white" class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <h2 style="text-align: center"><strong>How do you want to login?</strong></h2>
      </div>
      <div style="margin:auto" class="modal-footer">
      <a href="customer_login.php" class="btn btn-danger">As a Customer</a>
      <a href="garage_login.php" class="btn btn-danger">As a Garage Owner</a>
      <a href="admin_login.php" class="btn btn-danger">As a Admin</a>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="logoutask" tabindex="-1" aria-labelledby="logoutaskLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div style="border-radius: 25px; background-color: white" class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <h2 style="text-align: center"><strong>Do You really want to logout?</strong></h2>
      </div>
      <div style="margin:auto" class="modal-footer">
      <a href="partials/_logout.php" class="btn btn-danger">Logout</a>
      <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</div>';
