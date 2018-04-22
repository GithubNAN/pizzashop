<?php 
    session_start();
    include_once("./debug.php");
    //include_once("/home/eh1/e54061/public_html/wp/debug.php");
?>

<?php 
    // Check is $_GET set to help redirect
    if(!isset($_GET["pizza"])) {
        header("Location: products.php");
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

<!-- find relative string -->
<?php 
    $match = $_GET["pizza"];
    $matchArray = [];
    foreach($records[count($records)-1] as $pizza) {
        if ($pizza[1] === $match) {
            $matchArray = $pizza;
        }
    }
    $options = explode(", ", $matchArray[3]);
?>

<body>
    <!-- Inludes common HTML components, page header and nav-bar -->
    <?php include './components/header.php' ?>
    <?php require './components/nav.php' ?>

    <main>
        <div class="section product">
            <div class="container">
            <img src="<?php echo $matchArray[5]?>" alt="veggie" class="product-img" />
                <aside>
                    <h1><?php echo $matchArray[1]?></h1>
                    <p><?php echo $matchArray[2]?></p>
                    <h2>$<?php echo $matchArray[4]?></h2>
                    <form class="product-form" action="cart.php" method="post">
                        <label for="option">Way of Delivery</label>
                        <select name="option" id="method">
                            <option value="delivery"><?php echo $options[0]; ?></option>
                            <option value="takeaway"><?php echo $options[1]; ?></option>
                        </select>
                        <label for="qty">Number of Pizzas</label>
                        <input style="display: none" name="id" value=<?php echo $matchArray[0] ?> />
                        <input style="display: none" name="price" value=<?php echo $matchArray[4] ?> />
                        <input style="display: none" name="name" value=<?php echo $matchArray[1] ?> />
                        <button id="minus">-</button>
                        <input value=1 name="qty" id="quantity" />
                        <button id="plus">+</button>
                        <input type="submit" value="add" />
                    </form>
                </aside>
            </div>
        </div>
    </main>

    <!-- Page footer -->
    <?php require './components/footer.php' ?>

    <script src="js/product.js"></script>
</body>

</html>