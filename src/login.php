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
        <section class="section login">
            <div class="container">
                <form action="/" method="post" class="login-form">
                    <h1>Login</h1>
                    <label for="">Email:</label>
                    <input type="email" name="email" placeholder="Please enter your email..." />
                    <label for="">Password:</label>
                    <input type="password" name="password" placeholder="Please enter your password..." />
                    <input type="submit" />
                </form>
            </div>
        </section>
    </main>
    
    <!-- Page footer -->
    <?php require './components/footer.php' ?>
    
    <script src="js/login.js"></script>
</body>

</html>