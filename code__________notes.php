<?php
                $cr_id = $_SESSION['userid'];

                // Fetching Booking  data

                $bookdata = "SELECT *FROM `booking` WHERE `cr_id` = $cr_id ";
                $bookdatares = mysqli_query($conn, $bookdata);
                while ($bookrow = mysqli_fetch_assoc($bookdatares)) {
                    $bookgr = $bookrow['gr_id'];
                    $booksr = $bookrow['sr_id'];
                    $bookdate = $bookrow['bk_date'];
                    $booksrdate = $bookrow['sr_date'];
                    $bookcar = $bookrow['car_model'];
                    $bookcarno = $bookrow['car_no'];
                    $bookdes = $bookrow['sr_description'];
                    $bookstatus = $bookrow['bk_status'];
                














                 echo '<div class="card mb-3 service-card" style="width: 650px; height:700px;">
                    <div class="row g-0 service-body-div">
                        <div class="col-md-4 ">
                            <div class="booking-img-div">
                                <img src="/carwash.png" class="img-fluid rounded-start" alt="...">
                                <h6 class="mx-2 no-margin"><strong>this is a service number</strong></h6>
                                <p class="mx-2 no-margin" style="color: #c71e2f;"><strong>Price :</strong> 2000 rs.</p>
                            </div>
                            <hr style="margin:4px;  color: #000000;">
                            <div id="garage-details">
                                <p class="small-text my-1 mx-2"><i class="bi bi-truck"></i><strong style="color: #c71e2f;"> Car Details:
                                    </strong>'.$bookcar.'</p>
                                <p class="small-text my-1 mx-2"><i class="bi bi-pip-fill"></i><strong style="color: #c71e2f;"> Vehicle
                                        No: </strong>'.$bookcarno.'</p>
                                <hr style="margin:4px;  color: #000000;">

                                <p class="small-text my-1 mx-2"><i class="bi bi-calendar-event-fill"></i><strong style="color: #c71e2f;">
                                        Booking Date: </strong>'.$bookdate.'</p>
                                <p class="small-text my-1 mx-2"><i class="bi bi-calendar-plus"></i><strong style="color: #c71e2f;">
                                        Service Date: </strong>'.$booksrdate.'</p>
                                <p class="small-text my-1 mx-2"><i class="bi bi-check-circle-fill"></i><strong style="color: #c71e2f;">
                                        Booking Status: </strong><button type="button" id="status-button-cancel" class="btn btn-sm" disabled>'.$bookstatus.'</button>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <hr style="margin:4px;  color: #000000;">
                            <div class="sub-service-div">
                                <p class="small-text" style="color: rgb(0, 0, 0);"><strong>Garage Owner Deatails :</strong></p>
                                <p class="small-text mx-2"><i class="bi bi-gear-fill"></i><strong style="color: #c71e2f;"> Garage
                                        Name: </strong> <a href="#">microtech garage</a></p>
                                <p class="small-text mx-2"><i class="bi bi-person-fill"></i><strong style="color: #c71e2f;"> Owner:
                                    </strong>Ronak Gondaliya</p>
                                <p class="small-text mx-2"><i class="bi bi-telephone-fill"></i><strong style="color: #c71e2f;">
                                        Phone: </strong> 8905192161</p>
                            </div>
                            <hr style="margin:0px;  color: #000000;">
                            <div class="sub-service-div">
                                <p class="small-text" style="color: rgb(0, 0, 0);"><strong>Customer Deatails :</strong></p>
                                <p class="small-text mx-2"><i class="bi bi-person-circle"></i><strong style="color: #c71e2f;">
                                        Customer Name: </strong>Nayan Padshala</p>
                                <p class="small-text mx-2"><i class="bi bi-phone-fill"></i><strong style="color: #c71e2f;"> Phone:
                                    </strong> 8905192162</p>
                            </div>
                            <hr style="margin:0px;  color: #000000;">
                            <div class="sub-service-div">
                                <div>
                                    <div class="form-floating mx-2 my-2">
                                        <textarea id="service-msg" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">
                        A service is an " act or use for which a consumer, firm, or government is willing to pay." Examples include work done by barbers, doctors, lawyers, mechanics, banks, insurance companies, and so on. Public services are those that society as a whole pays for.</textarea>
                                        <label for="floatingTextarea2">Service description</label>
                                    </div>
                                    <button style="display:block; margin:auto;" type="button" class="btn btn-primary my-2 btn-sm">Cancel Service</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';






            }


            ?>