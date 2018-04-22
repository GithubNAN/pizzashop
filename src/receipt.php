<?php 
    session_start();
    // include_once("/home/eh1/e54061/public_html/wp/debug.php"); 
    include_once("./debug.php");
    // echo "<pre>";
    // print_r($_SESSION);
    // print_r($_COOKIE);
    // echo "</pre>"
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
    <link rel="stylesheet" href="css/invoice.css">
    <title>My Pizza Workshop</title>

</head>

<body>
    <!-- Inludes common HTML components, page header and nav-bar -->
    <?php include './components/header.php' ?>
    <?php require './components/nav.php' ?>

    <main>
        <section class="container">
            <div class="invoice-box">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td>
                                        Invoice #: 001
                                        <br> Created: <?php $date = date('j') . ' ' . date('M') . ' ' . date('Y'); echo $date; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="information">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td>
                                        pizza workshop, 
                                        <br> 12345 Sunny Road
                                        <br> Sydney, NSW, 2000
                                    </td>

                                    <td>
                                        Customer #: <?php echo $_COOKIE['PHPSESSID']; ?>
                                        <br> <?php echo $_SESSION['user']['name']; ?>
                                        <br> <?php echo $_SESSION['user']['email']; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="heading">
                        <td>
                            Payment Method
                        </td>

                        <td>
                            Credit Card #
                        </td>
                    </tr>

                    <tr class="details">
                        <td>
                            Credit Card
                        </td>

                        <td>
                            <?php 
                                echo str_pad(substr($_SESSION['user']['credit'], -4), strlen($_SESSION['user']['credit']), '*', STR_PAD_LEFT); 
                            ?>
                        </td>
                    </tr>

                    <tr class="heading">
                        <td>
                            Item
                        </td>

                        <td>
                            Price
                        </td>
                    </tr>

                    <?php
                        $total = 0;
                        foreach($_SESSION['cart'] as $key => $value) {
                            echo '<tr class="item"';
                            echo '<td>';
                            echo $value['id'];
                            echo '</td>';
                            echo '<td>';
                            echo $value['name'];
                            echo '</td>';
                            echo '<td>';
                            echo '$' . $value['price'] * $value['qty'];
                            $total = $value['price'] * $value['qty'] + $total;
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>

                    <tr class="total">
                        <td></td>

                        <td>
                            <?php echo '$' . $total ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
    </main>
    <?php
        // Create a file assoiative file 
        $filename = "orders.csv";
        $headings = ['Purchase Date', 'Name', 'Address', 'Mobile', 'Email', 'ID', 'Option', 'Quantity', 'Unit Price', 'Subtotal'];
        $data = '';
        $fp = fopen($filename, "w");
        flock($fp, LOCK_EX);
        fputcsv($fp, $headings);
        foreach($_SESSION['cart'] as $key => $value) {
            $data = [$date, $_SESSION['user']['name'], $_SESSION['user']['address'], $_SESSION['user']['mobile'], $_SESSION['user']['email'], $_COOKIE['PHPSESSID'], $value['option'], $value['qty'], $value['price'],  $value['option']*$value['option'] ];
            fputcsv($fp, $data);
        }
        flock($fp, LOCK_UN);
        fclose($fp);

    ?>
    <!-- Page footer -->
    <?php require './components/footer.php' ?>
</body>