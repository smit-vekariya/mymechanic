<?php
$selfpath = $_SERVER['PHP_SELF'];
if(isset($_GET['applybooking'])){

  //booking data start
  $service_date = $_POST['servicedate'];
  $service_time = $_POST['servicetime'];
  $carcompany = $_POST['carcompany'];
  $carmodel = $_POST['carmodel'];
  $carfuel = $_POST['carfuel'];
  $carnumber =$_POST['carnumber'];
  $servicedes =$_POST['servicedes'];
  $cardetails = $carcompany.",".$carmodel.",".$carfuel;
  $servicedatetime = $service_date." ".$service_time;
  //booking data finish

  
  //other data start
  $crid = $_SESSION['userid'];
  $service_id =  $_GET['applybooking'];
  //other data End
  
  //who provide ther service 
  $serquery = "SELECT *FROM `service` WHERE `s_id` = '$service_id'";
  $serresult = mysqli_query($conn,$serquery);
  $serrow = mysqli_fetch_assoc($serresult);
  $ser_by = $serrow['s_by'];
  //who provide ther service 
  
  
  if($ser_by == 'mymechanic'){
    $bookquery = "INSERT INTO `booking` (`cr_id`, `sr_id`, `gr_id`, `bk_date`, `sr_date`, `car_model`, `car_no`,`sr_by`,`sr_description`,`bk_status`) VALUES ('$crid', '$service_id', null, current_timestamp(), '$servicedatetime', '$cardetails', '$carnumber','$ser_by','$servicedes','placed')";
  }else{
    $bookquery = "INSERT INTO `booking` (`cr_id`, `sr_id`, `gr_id`, `bk_date`, `sr_date`, `car_model`, `car_no`,`sr_by`,`sr_description`,`bk_status`) VALUES ('$crid', '$service_id', '$ser_by', current_timestamp(), '$servicedatetime', '$cardetails', '$carnumber','$ser_by','$servicedes','placed')";
  }

  $bookqueryresult = mysqli_query($conn,$bookquery);
  if($bookqueryresult){
    echo '
    <button class="btn btn-danger mx-1" style="display:none;" id="clickme2" data-bs-toggle="modal" data-bs-target="#booksuccess">Logout</button>
    <script>
    window.onload = function() {
        document.getElementById("clickme2").click();
    }
    </script>
    
    <div class="modal fade" id="booksuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div style="border-radius: 25px; background-color: white" class="modal-content">
      <div class="modal-header">
        <a href="index.php" type="button" class="btn-close"  aria-label="Close"></a>
      </div>
      <div class="modal-body">
       <h2 style="text-align: center"><i class="bi bi-check-circle-fill" style="font-size: 40px; color:green;"></i> <strong>Booking Successfull!!</strong></h2>
      </div>
      <div style="margin:auto" class="modal-footer">
      <a href=order.php" class="btn btn-danger">View Booking</a>
      <a href="index.php" class="btn btn-secondary">Ok</a>
      </div>
      </div>
      </div>
    </div>
    </div>';

  }
  else{
    die(mysqli_error($conn));
  }


}














if(isset($_GET['booking'])){
  $s_id = $_GET['booking'];

    echo '
    <button class="btn btn-danger mx-1" style="display:none;" id="clickme" data-bs-toggle="modal" data-bs-target="#booking">Logout</button>
    <script>
    window.onload = function() {
        document.getElementById("clickme").click();
    }
    </script>
    
    <div class="modal fade" id="booking" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div style="border-radius: 25px; background-color: white" class="modal-content">
      <div class="modal-header">
      <h4>Enter Booking Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

    <form action="'.$selfpath.'?applybooking='.$s_id.'&cat_id=' . $catid . '" method="POST">
      <div class="form-field-merge" style="display:flex; flex-direction:row; flex-wrap:wrap">
                <div class="mx-2" style="width:190px">
                <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Car Company :</h6>
                <input type="text" class="form-control"  name="carcompany" required="required" />
                </div>
                <div class="mx-2" style="width:190px">
                <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Car Model :</h6>
				        <input type="text" class="form-control" name="carmodel" required="required" />
                </div>
                <div class="mx-2" style="width:190px">
                <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Fuel type :</h6>
			        	<select class="form-select" name="carfuel" aria-label="Default select example">
                <option selected>Diesel</option>
                <option value="Patrol">Patrol</option>
                <option value="CNG">CNG</option>
                <option value="Charging">Charging</option>
                </select>
			    </div>
		</div>

        <div class="form-field-merge my-4" style="display:flex; flex-direction:row; flex-wrap:wrap">
                <div class="mx-2" style="width:190px">
                <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Vehicle No :</h6>
                <input type="text" class="form-control"  name="carnumber" required="required" />
                </div>
              <div class="mx-2" style="width:190px;">
              <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Wnen will you come with car?</h6>
              <input type="date" class="form-control"  name="servicedate" required="required" />
              </div>
              <div class="mx-2" style="width:190px;">
              <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Service Time :</h6>
				      <input type="time" class="form-control" name="servicetime" required="required" />
              </div>
		</div>
          <h6 style="margin-bottom: 0px; font-size: 14px; color: #bb2d3b;">Describe your service requairment in few words</h6>
          <textarea class="form-control"  maxlength="150" name="servicedes" required="required"></textarea>
      </div>
      <div style="margin:auto" class="modal-footer">
      <button type="submit" class="btn btn-danger">Confirm</a>
      <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </form>

      </div>
    </div>
  </div>
</div>
</div>';
}



?>