<?php 
    session_start();
    // include_once("/home/eh1/e54061/public_html/wp/debug.php");
    // include_once("./debug.php")
    include_once("./debug.php");
?>
<?php
    // Server side validation
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'], $_POST['qty'], $_POST['option'])) {
            // server side code is required here to check if
            //  - qty is a positive integer (ie 1 or more)
            if ((int)$_POST['qty'] <= 0) {
                // echo "qantity can't not be less 0 or 0";
                $_SESSION['validation']['cart'] = 'invalid post qty';
                header("Location: products.php");
            }
            //  - product/service id is valid
            if (!preg_match("/^P00[1-6]/", $_POST['id'])) {
                $_SESSION['validation']['cart'] = 'invalid post id';
                header("Location: products.php");
            }
            //  - product/service option is valid
            if ($_POST['option'] !== "takeaway" && $_POST['option'] !== 'delivery') {
                $_SESSION['validation']['cart'] = 'invalid post option';
                header("Location: products.php");
            }
    
            // Add qty to items
            if (isset($_SESSION['cart'][$_POST['id']]['option'])) {
                $_SESSION['cart'][$_POST['id']]['qty'] = (int)$_POST['qty'] + $_SESSION['cart'][$_POST['id']]['qty'];
            } else {
                $_SESSION['cart'][$_POST['id']]['qty'] = (int)$_POST['qty'];
            }
    
            // repeat to add the valid option 
            $_SESSION['cart'][$_POST['id']]['option'] = $_POST['option'];
            $_SESSION['cart'][$_POST['id']]['name'] = $_POST['name'];
            $_SESSION['cart'][$_POST['id']]['price'] = $_POST['price'];
        } else {
            $_SESSION['validation']['cart'] = "missing post information";
            header("Location: products.php");
        }

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
    <link rel="stylesheet" href="css/cart.css">
    <title>My Pizza Workshop</title>

</head>

<!-- Retrive from customers provided csv file or loaded from local store -->
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

<body>
    <!-- Inludes common HTML components, page header and nav-bar -->
    <?php include './components/header.php' ?>
    <?php include './components/nav.php' ?>

    <main>
        <div class="container-fluid cart-container">
            <div class="table-row header">
                <div class="text">Items</div>
                <div class="text">Quantity</div>
                <div class="text">Options</div>
                <div class="text">Unit Price</div>
                <div class="text">Subtotal</div>
            </div> 

            <?php 
                // find array of item
                if(isset($_SESSION["cart"])) {
                    foreach($_SESSION["cart"] as $key => $item) {
                        $match = $key;
                        $matchArray = [];
                        foreach($records[count($records)-1] as $pizza) {
                            if ($pizza[0] === $match) {
                                $matchArray = $pizza;
                            }
                        }
    
                        echo '<div class="table-row">';
                        echo '<div class="text item">' . $matchArray[1] . '</div>';
                        echo '<div class="text item">' . $item["qty"] . '</div>';
                        echo '<div class="text item">' . $item["option"] . '</div>';
                        echo '<div class="text item">' . (float)$matchArray[4] . '</div>';
                        echo '<div class="text item">' . $item["qty"] * (float)$matchArray[4] . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<h2 class="banner">Shopping cart is empty</h2>';
                }
            ?>
        </div>

        <section>
            <div class="cart-container">
                <ul class="cart-button-group">
                    <li>
                        <form action="products.php" method="post">
                            <button class="cancel" type="submit" name="cancel" value="true">Cancel</button>
                        </form>
                    </li>
                    <li><a href="./products.php"><button>Continue Shopping</button></a></li>
                    <li><a href="./checkout.php"><button>Checkout</button></a></li>
                </ul>
            </div>
        </section>
    </main>

    <!-- Page footer -->
    <?php include './components/footer.php' ?>
</body>