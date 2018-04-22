<?php 
    session_start(); 
    //include_once("/home/eh1/e54061/public_html/wp/debug.php");
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>"
    include_once("./debug.php")
?>
<?php 
    // Check if $_POST have cancel attribute
    if (isset($_POST['cancel'])) {
        unset($_SESSION['cart']);
        unset($_SESSION['validation']);
        unset($_SESSION['user']);
    }
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
    <!-- Retrive from customers provided csv file or loaded from llcal store -->
    <?php
        $filename = "products.csv";
        $fp = fopen($filename, "r");
        flock($fp, LOCK_SH);

        $headings = fgetcsv($fp, 0, "|");
        while ($aLineOfCells[] = fgetcsv($fp, 0, "|")) {
             $records[] = $aLineOfCells;
         }
        flock($fp, LOCK_UN);
        fclose($fp);
    ?>

    <!-- Show validation errors -->
    <?php 
        if(isset($_SESSION['validation']['cart'])) {
            echo '<h2 style="color: red; top: 0; left: o; position: absolute">' . $_SESSION['validation']['cart'] . '</h2>';
        }
    ?>
    
    <!-- Inludes common HTML components, page header and nav-bar -->
    <?php include './components/header.php' ?>
    <?php require './components/nav.php' ?>

    <!-- Render list of products -->
    <main>
        <div class="section products">
            <h1>Pizzas</h1>
            <div class="grid">
                <?php
                  foreach($records[count($records)-1] as $value) {
                    echo '<div class="card">';
                        echo '<div class="img-holder">';
                            echo '<a href="product.php?pizza='.$value[1].'"><img src='.$value[5].' /></a>';
                        echo '</div>';
                        echo '<h1>'.$value[1].'</h1>';
                        echo '<p>'.$value[2].'</p>';
                    echo '</div>';
                  }
                ?>
            </div>
        </div>
    </main>

    <!-- Page footer -->
    <?php require './components/footer.php' ?>
</body>
</html>