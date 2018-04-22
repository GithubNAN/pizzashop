<?php 
    session_start();
    include_once("./debug.php");
    // include_once("/home/eh1/e54061/public_html/wp/debug.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Pangolin" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <title>My Pizza Workshop</title>

</head>

<body>
    <!-- Inludes common HTML components, page header and nav-bar -->
    <?php include './components/header.php' ?>
    <?php require './components/nav.php' ?>

    <main>
        <!-- Carousel section -->
        <section class="section carousel">
            <div class="img img-1">
                <div class="hgroup">
                    <h1>We Have What You Want</h1>
                    <h6>The rules of eating out no longer apply, whatever you taste, we serve it up</h6>
                </div>
            </div>
            <div class="img img-2">
                <div class="hgroup">
                    <h1>Naturally Delicious</h1>
                    <h6>A cool bed of crisp greens, juicy cherry tomato, Crunchy croutons</h6>
                </div>
            </div>
            <div class="img img-3">
                <div class="hgroup">
                    <h1>Flavor Takes Flight</h1>
                    <h6>How do you make you trip to PizzaWorkshop even better? order online!</h6>
                </div>
            </div>
            <div class="img img-4">
                <div     class="hgroup">
                    <h1>Discover Pizza Workshop</h1>
                    <h6>Weather your are meat lover or vegan believer, Pizza Workshop allways have ways to serve you</h6>
                </div>
            </div>
            <div class="controller left" id="left"></div>
            <div class="controller right" id="right"></div>
        </section>
        <!-- Feature Section -->
        <section class="section feature-section">
            <h1 style="padding-bottom: 30px; text-align:center;">Our store provides</h1>
            <div class="feature">
                <div class="feature-item">
                    <!--brand icon-->
                    <div class="font-awesome">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Diner</h3>
                    <p>Plenty of tables in store for you to enjoy your lovely night</p>
                </div>
                <div class="feature-item">
                    <div class="font-awesome">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <h3>Free WiFi</h3>
                    <p>24/7 free WiFi keep you allways connect to the world</p>
                </div>
                <div class="feature-item">
                    <div class="font-awesome">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Credit card accepted</h3>
                    <p>No cash? No problems, we accept Master Card&reg;, Visa&reg;, and American Express&reg;</p>
                </div>
                <div class="feature-item">
                    <div class="font-awesome">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Free Delivery*</h3>
                    <p>Order 10 pizza in one time, you get it, we have FREE delivery!</p>
                </div>
            </div>
        </section>
        <section>
            <div class="subsribe">

            </div>
        </section>
    </main>
    
    <!-- Page footer -->
    <?php require './components/footer.php' ?>
    
    <script src="js/main.js"></script>
    <script src="js/carousel.js"></script>
</body>

</html>