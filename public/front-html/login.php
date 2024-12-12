<?php include 'include/header.php' ?>

<section class="sign-in-sec">
    <div class="container-fluid p-0">
        <div class="row align-items-center justify-content-center sign-up-row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 p-0 right-content">
                <div class="sign-in-left sign-up-left">
                    <div class="logo-container">
                        <img src="images/main-logo.png" class="img-fluid" alt="">
                    </div>
                    <div class="log-in-content">
                        <h1>Log in to your account</h1>
                        <p>Please enter your information here to view details</p>
                    </div>
                    <div class="log-in-foam">
                        <form>
                            <div class="cridentials">
                                <label for="exampleInputEmail1" class="form-label">E-Email</label>
                                <input type="email" class="form-control" placeholder="Enter your email address"
                                    id="exampleInputEmail1" aria-describedby="emailHelp">
                                <span class="icons">
                                    <img src="images/icon-1.png" class="img-fluid" alt="">
                                </span>
                            </div>
                            <div class="cridentials">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="Enter your password "
                                    id="exampleInputPassword1">
                                <span class="icons">
                                    <img src="images/icon-2.png" class="img-fluid" alt="">
                                </span>
                            </div>
                            <div class="cridentials-check form-check">
                                <span>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Remeber me</label>
                                </span>
                                <span class="forget-pass">
                                    <a href="javascript:;">Forget Password</a>
                                </span>
                            </div>
                            <button type="submit" class="btn custom-btn-login">Submit</button>


                            <div class="Need-Help">
                                <p>
                                    Need Help?
                                    <span>
                                        <a href="#">Contact Us</a>
                                    </span>
                                </p>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 p-0 slider-main-colum" id="hide-on-mobile">
                <div class="slider-main">
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php' ?>
