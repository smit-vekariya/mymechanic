<h1 class="mt-4"><i class="bi bi-bookmark-check-fill"></i> Internal label</h1>
                <hr>

                <!-- External label start------------------------------------------------------------------ -->
                <div class="card mx-5 my-5 garage-label">
                    <div class="garage-card-header">
                        <h5 class="my-1 px-3">Contact : </h5>
                        <p class="px-1 my-1"><i style="color:rgb(204, 0, 0)" class="bi bi-phone-fill"></i> <?php echo  $g_phone ?>
                        </p>
                        <p class="px-1 my-1"><i style="color:green" class="bi bi-envelope-fill"></i>
                            nayan.padshala@gmail.com</p>
                    </div>
                    <div class="card-body text-light garage-body mt-5 ">
                        <h5 class="card-title mt-5" style="color:rgb(0, 177, 0)"><i class="bi bi-geo-alt-fill"></i>
                            Garage Address</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <h5 class="card-title mt-4" style="color:rgb(0, 177, 0)"><i class="bi bi-question-circle-fill"></i> About Us
                        </h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <h5 class="card-title mt-4" style="color:rgb(0, 177, 0)"><i class="bi bi-tools"></i> Popular
                            Categories</h5>
                        <p><i class="bi bi-check-circle" style="color:red"></i> Car painting</p>
                        <p><i class="bi bi-check-circle" style="color:red"></i> Spa after painting</p>
                    </div>
                </div>
                <!-- External label End------------------------------------------------------------------ -->



                <!-- internal label start------------------------------------------------------------------ -->
                <div style="margin-top:500px">
                    <h1 class="mt-4"><i class="bi bi-bookmark-check-fill"></i> External label</h1>
                    <hr>

                    <div class="card mx-5 my-5 garage-card" style="width: 18rem;">
                        <img src="garage.jpg" class="card-img-top" alt="Upload image">
                        <div class="garage-card-body">
                            <h4 class="card-title" style="margin-top:5px"><strong><?php echo $g_name ?></strong></h4>
                            <p class="card-text"><i class="bi bi-geo-alt-fill" style="color: red; font-size: 20px;"></i> <?php echo $g_address ?></p>
                        </div>
                        <div class="sub-service-div ">
                            <hr style="margin: 0px">
                            <p id="popular-item">Popular Categories</p>
                            <p><i class="bi bi-check-circle"></i> Car painting</p>
                            <p><i class="bi bi-check-circle"></i> Spa after painting</p>
                            <hr style="margin: 0px">
                        </div>
                        <div class="garage-card-body garage-buttons">
                            <button type="button" class="btn btn-danger btn-sm">View Garage</button>
                            <a href="#" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Book mark" class="btn btn-white"><i type="button" class="bi bi-star" style="font-size: 23px; color:rgb(216, 216, 0);"></i></a>
                        </div>
                    </div>
                </div>
                <!-- internal label End------------------------------------------------------------------ -->
