    <!-- cart modal  Start ----------------------------------------------------------------------------- -->
    <div class="modal fade" id="bookmark" tabindex="-1" aria-labelledby="bookmark" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" style=" border:none; border-radius: 20px;">
                <div class="modal-header ">
                    <h5 class="modal-title" id="bookmark">Book Marks</h5>
                    <div class="btn-group " style="margin:auto;" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                        <label class="btn btn-outline-danger" onclick="showservice()" for="btnradio1">Services</label>

                        <input type="radio" class="btn-check" onclick="showgarage()" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-danger" for="btnradio2">Garages</label>  

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>



                <div class="modal-body" id="servicebook" style="margin:auto; display:block">
                    <?php
                    $selfpath = $_SERVER['PHP_SELF'];
                    $user_id = $_SESSION['userid'];
                    $usertype = $_SESSION['usertype'];

                    $checkbooks = "SELECT *FROM `bookmark` WHERE `book_type` ='service' AND `user_id` = '$user_id' ";
                    $checkbooksresult = mysqli_query($conn, $checkbooks);
                    $num = mysqli_num_rows($checkbooksresult);

                    while ($bookmarkidsrow = mysqli_fetch_assoc($checkbooksresult)) {
                        $s_id = $bookmarkidsrow['book_type_id'];

                        $gets = "SELECT *FROM `service` WHERE  `s_id` = '$s_id' AND `s_status` = 'Active' ";
                        $getsresult = mysqli_query($conn, $gets);
                        while ($getsrow = mysqli_fetch_assoc($getsresult)) {
                            $catid = $getsrow['cat_id'];
                            $s_img = "data:image/jpg;base64," . base64_encode($getsrow['s_image']);
                            $s_by = $getsrow['s_by'];
                            //Checckin Who provides Service start
                            if ($s_by == 'mymechanic') {
                                $serviceby = 'mymechanic';
                            } else {
                                $findsql = "SELECT *FROM `garage_owner` WHERE `g_id` = '$s_by'";
                                $findres = mysqli_query($conn, $findsql);
                                $findrow = mysqli_fetch_assoc($findres);
                                $serviceby = $findrow['g_name'];
                            }
                            //Checckin Who provides Service start
                            echo '
                            <div class="card mb-3 service-card" style="max-width: 540px;">
                                    <div class="row g-0 service-body-div">
                            <div class="col-md-4 service-img-div">
                            <img src="' . $s_img . '" class="img-fluid rounded-start" alt="...">
                            <h5 style="color: #bd1828; font-weight: 650; margin-bottom: 2px; margin-top: 10px;">Price ' . $getsrow["s_price"] . '/-</h5>
                            <h6 style="margin-top: 2px;">Rs. Only</h6>
                            </div>
                            <div class="col-md-8">
                            <div class="card-body service-title-des">
                                <h4 class="card-title"><i class="bi bi-check-circle-fill"> </i><strong>' . $getsrow["s_name"] . '</strong></h4>
                                <h6 style="color: rgb(85, 85, 85); min-height:57.56px">' . $getsrow["s_description"] . '</h6>
                            </div>
                            <hr style="margin:0px;  color: #000000;">
                            <div class="sub-service-div">
                                <p><i class="bi bi-check-circle"></i> ' . $getsrow["s_special1"] . '</p>
                                <p><i class="bi bi-check-circle"></i> ' . $getsrow["s_special2"] . '</p>
                                <p><i class="bi bi-check-circle"></i> ' . $getsrow["s_special3"] . '</p>
                                <hr style="margin:0px;  color: #000000;">
                                <p style="font-size:12px"><i class="bi bi-check-circle-fill" style="color:red;"></i> <strong>Service By: ' . $serviceby . '</strong><p>
                                </div>
                            <hr style="margin:0px;  color: #000000;">';
                            if ($usertype != 'admin') {
                                if ($num >= 1) {
                                    echo '<div class="service-card-buttons">
                                    <a href="'.$selfpath.'?booking='.$s_id.'&cat_id=' . $catid . '" type="button" class="btn btn-danger btn-sm">Book Service</button>
                                    <a href="service.php?cat_id=' . $catid . '&servicemark=' . $getsrow['s_id'] . '" type="button"data-bs-toggle="tooltip" data-bs-placement="right" title="Remoove from Bookmark" class="btn btn-white"><i type="button" class="bi bi-star-fill" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                                    </div>';
                                } else {
                                    echo '<div class="service-card-buttons">
                                    <a href="'.$selfpath.'?booking='.$s_id.'&cat_id=' . $catid . '" type="button" class="btn btn-danger btn-sm">Book Service</button>
                                    <a href="service.php?cat_id=' . $catid . '&servicemark=' . $getsrow['s_id'] . '" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                                    </div>';
                                }
                            }
                            echo '</div>
                            </div>
                        </div>';
                        }
                    }
                    ?>
                    <a href="category.php" type="button" style="width:200px; display:block; margin:auto;" class="btn btn-secondary my-2 mt-2">Add Service</a>
                </div>




                <div class="modal-body" id="garagebook" style="margin:auto; display:none">
                    <?php
                    $user_id = $_SESSION['userid'];
                    $usertype = $_SESSION['usertype'];

                    $checkbooks = "SELECT *FROM `bookmark` WHERE `book_type` ='garage' AND `user_id` = '$user_id' ";
                    $checkbooksresult = mysqli_query($conn, $checkbooks);
                    $num = mysqli_num_rows($checkbooksresult);
                    while ($bookmarkidsrow = mysqli_fetch_assoc($checkbooksresult)) {
                        $g_id = $bookmarkidsrow['book_type_id'];

                        $gdata = "SELECT *FROM `garages` INNER JOIN `garage_owner` ON garages.gr_id=garage_owner.g_id WHERE `gr_id` = $g_id";
                        $gdataresult = mysqli_query($conn, $gdata);
                        while ($grrown = mysqli_fetch_assoc($gdataresult)) {
                            $grid = $grrown['gr_id'];
                            $grname = $grrown['g_name'];
                            $graddress = $grrown['g_address'];
                            $grzip = $grrown['g_zipcode'];
                            $grcity = $grrown['g_city'];
                            $grlphoto =  "data:image/jpg;base64," . base64_encode($grrown['grl_photo']);
                            $grspecial1 = $grrown['gr_special1'];
                            $grspecial2 = $grrown['gr_special2'];

                            echo '<div class="card mx-4 my-3 garage-card" style="width: 18rem;">
                        <img src="' . $grlphoto . '" style="width: 268px; height: 214px;"class="card-img-top" alt="...">
                        <div class="garage-card-body">
                            <h4 class="card-title" style="margin-top:5px"><strong>' . $grname . '</strong></h4>
                            <p class="card-text" style="min-height: 80px;"><i class="bi bi-geo-alt-fill" style="color: red; font-size: 20px;"></i>' . $grcity . '-' . $grzip . '<br>' . $graddress . '</p>
                        </div>
                        <div class="sub-service-div ">
                            <hr style="margin: 0px">
                            <p id="popular-item">Popular Categories</p>
                            <p><i class="bi bi-check-circle"></i> ' . $grspecial1 . '</p>
                            <p><i class="bi bi-check-circle"></i> ' . $grspecial2 . '</p>
                            <hr style="margin: 0px">
                        </div>
                        <div class="garage-card-body garage-buttons">
                            <a href="category.php?garageid=' . $grid . '" type="button" class="btn btn-danger btn-sm">View Garage</a>
                            <a href="garages.php?servicemark=' . $grid . '" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star-fill" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                            </div>
                        </div>';
                        }
                    }
                    ?>

                    <a href="garages.php" type="button" style="width:200px; display:block; margin:auto;" class="btn btn-secondary my-2 mt-2">Add Garage</a>
                </div>











                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>







    <div class="modal fade" id="notlogin" tabindex="-1" aria-labelledby="notlogin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div style="border-radius: 25px; background-color: white" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 style="text-align: center"><strong>Sorry!! You are not logged in.</strong></h2>
                </div>
                <div style="margin:auto" class="modal-footer">
                    <a href="customer_login.php" class="btn btn-danger">Login</a>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- cart modal End ----------------------------------------------------------------------------- -->