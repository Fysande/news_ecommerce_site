<!DOCTYPE html>
<html>
<head>
	<title>Make Payment</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Timati Developer">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../css/main.css" />
	<script src="js/jquery-3.6.0.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>

    <!--  ======================= Start Navbar Area ============================== -->
            <nav class="navbar navbar-expand-lg navbar-light fixed-top">
                <a class="navbar-brand" href="#">NEWS DISTRIBUTION WEBSITE</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="mr-auto"></div>
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Log Out</a>
                        </li>

                    </ul>
                </div>
            </nav>
    <!--  ======================= End Navbar Area ============================== -->

    <!--  ======================= Start page title Area ============================== -->
    
		<!-- portfolio -->
	<div class="page_heading" id="portfolio">
	     <h1 class="text-center">SELECT YOUR SUBSCRIPTION PLAN</h1>
	</div>
	<!--  ======================= end page title Area ============================== -->

	<!-- portfolio -->
	<div class="pricing" id="portfolio">
		<section class="pricing-table">
			<div class="container">
				<div class="block-heading">
				</div>
				<div class="row justify-content-md-center">
					<div class="col-md-5 col-lg-4">
						<div class="item text-center">
							<div class="heading">
								<h3>BASIC</h3>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<div class="features">
								<h4><span class="feature">Full Support</span> : <span class="value">No</span></h4>
								<h4><span class="feature">Duration</span> : <span class="value">30 Days</span></h4>
								<h4><span class="feature">Storage</span> : <span class="value">10GB</span></h4>
							</div>
							<div class="price">
								<h4>$25</h4>
							</div>
							<form class="paypal" action="back-end/payment.php" method="post" id="paypal_form">
						        <input type="hidden" name="cmd" value="_xclick" />
						        <input type="hidden" name="no_note" value="1" />
						        <input type="hidden" name="lc" value="UK" />
						        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
						        <input type="hidden" name="first_name" value="Customer's First Name" />
						        <input type="hidden" name="last_name" value="Customer's Last Name" />
						        <input type="hidden" name="payer_email" value="customer@example.com" />
						        <input type="hidden" name="item_number" value="1" / >
						        <input class="btn btn-outline-primary btn-block" type="submit" name="submit" value="BUY NOW"/>
						    </form>
						</div>
					</div>
					<div class="col-md-5 col-lg-4">
						<div class="item">
							<div class="ribbon">Best Value</div>
							<div class="heading">
								<h3>PRO</h3>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<div class="features">
								<h4><span class="feature">Full Support</span> : <span class="value">Yes</span></h4>
								<h4><span class="feature">Duration</span> : <span class="value">60 Days</span></h4>
								<h4><span class="feature">Storage</span> : <span class="value">50GB</span></h4>
							</div>  
							<div class="price">
								<h4>$50</h4>
							</div>
							<form class="paypal" action="back-end/payment.php" method="post" id="paypal_form">
						        <input type="hidden" name="cmd" value="_xclick" />
						        <input type="hidden" name="no_note" value="1" />
						        <input type="hidden" name="lc" value="UK" />
						        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
						        <input type="hidden" name="first_name" value="Customer's First Name" />
						        <input type="hidden" name="last_name" value="Customer's Last Name" />
						        <input type="hidden" name="payer_email" value="customer@example.com" />
						        <input type="hidden" name="item_number" value="2" / >
						        <input class="btn btn1 btn-outline-primary btn-block" type="submit" name="submit" value="BUY NOW"/>
						    </form>
						</div>
					</div>
					<div class="col-md-5 col-lg-4">
						<div class="item">
							<div class="heading">
								<h3>PREMIUM</h3>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<div class="features">
								<h4><span class="feature">Full Support</span> : <span class="value">Yes</span></h4>
								<h4><span class="feature">Duration</span> : <span class="value">120 Days</span></h4>
								<h4><span class="feature">Storage</span> : <span class="value">150GB</span></h4>
							</div>
							<div class="price">
								<h4>$150</h4>
							</div>
							<form class="paypal" action="back-end/payment.php" method="post" id="paypal_form">
						        <input type="hidden" name="cmd" value="_xclick" />
						        <input type="hidden" name="no_note" value="1" />
						        <input type="hidden" name="lc" value="UK" />
						        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
						        <input type="hidden" name="first_name" value="Customer's First Name" />
						        <input type="hidden" name="last_name" value="Customer's Last Name" />
						        <input type="hidden" name="payer_email" value="customer@example.com" />
						        <input type="hidden" name="item_number" value="3" / >
						        <input class="btn btn-outline-primary btn-block" type="submit" name="submit" value="BUY NOW"/>
						    </form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>



  <!--  Jquery js file  -->
    <script src="./js/nav/jquery.3.4.1.js"></script>
    <!--  Bootstrap js file  -->
    <script src="./js/nav/bootstrap.min.js"></script>
	<script type="text/javascript" src='js/main.js'></script>
</body>
</html>