<?php 
    session_start(); 
    
    // include_once("/home/eh1/e54061/public_html/wp/debug.php");
    // if (!isset($_SESSION['validation']['checkout'])) {
    //     $_SESSION['validation']['checkout'] = [];
    // }

    if (isset($_POST['name'], $_POST['address'], $_POST['mobile'], $_POST['credit'], $_POST['expire'])) {


        if (isset($_SESSION['validation']['checkout']['name'])) {
            unset($_SESSION['validation']['checkout']['name']);
        }
        // Test name
        if (preg_match("/[0-9\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\+\&\!\[\]]+/i", $_POST['name'])) {
            $_SESSION['validation']['checkout']['name'] = 'Invalid name';
            header("Location: checkout.php");
        } else {
            $_SESSION['user']['name'] = $_POST['name'];
            if (isset($_SESSION['validation']['checkout']['name'])) {
                unset($_SESSION['validation']['checkout']['name']);
            }
        }

        // Test address
        // $addressPattern = "/[a-z0-9\ \'\,\.\-\/]+/im";
        if (preg_match("/[\^<@\{\}\(\)\*\$%\?=>:\|;#\+\&\!\[\]]+/i", $_POST['address'])) {
            $_SESSION['validation']['checkout']['address'] = 'Invalid address';
            header("Location: checkout.php");
        } else {    
            $_SESSION['user']['address'] = $_POST['address'];
            if (isset($_SESSION['validation']['checkout']['address'])) {
                unset($_SESSION['validation']['checkout']['address']);
            }
        }

        // Test mobile
        $phonePattern = "/^\+614|\(04\)|04[0-9]{8}/";
        if (!preg_match($phonePattern, $_POST['mobile'])) {
            $_SESSION['validation']['checkout']['mobile'] = 'Invalid mobile';
            header("Location: checkout.php");
        } 
        $number = preg_replace("/^\+614|\(04\)|04/", "", $_POST['mobile']);
        if (preg_match('/[a-z-\"\' ,\^<@\{\}\(\)\*\$%\?=>:\|;#\+\&\!\[\]\/\.]+/i', $number) || strlen($number) !== 8) {
            $_SESSION['validation']['checkout']['mobile'] = 'Invalid mobile';
        } else {
            $_SESSION['user']['mobile'] = $_POST['mobile'];
            if (isset($_SESSION['validation']['checkout']['mobile'])) {
                unset($_SESSION['validation']['checkout']['mobile']);
            }
        }

        // Test credit card
        $cards = array($_POST['credit']);
        foreach($cards as $c) {
            $check = check_cc($c, true);
            if ($check === false) {
                $_SESSION['validation']['checkout']['credit'] = 'Invalid credit card';
                header("Location: checkout.php");
            } else {
                $_SESSION['user']['credit'] = $_POST['credit'];
                if (isset($_SESSION['validation']['checkout']['credit'])) {
                    unset($_SESSION['validation']['checkout']['credit']);
                }
            }
        }

        // Test credit card expire
        $expire = explode("/", $_POST['expire']);
        $expireMonth = $expire[0];
        $expireYear = $expire[1];
        $expires = \DateTime::createFromFormat('my', $expireMonth.$expireYear);
        $now = new \DateTime();
        if ($expires < $now) {
            $_SESSION['validation']['checkout']['expire'] = 'Credit card expired';
            header("Location: checkout.php");
        }   else {
            $_SESSION['user']['expire'] = $_POST['expire'];
            if (isset($_SESSION['validation']['checkout']['expire'])) {
                unset($_SESSION['validation']['checkout']['expire']);
            }
        }

        $_SESSION['user']['email'] = $_POST['email'];

        // All passed
        // unset($_SESSION['validation']['checkout']);
        header("Location: receipt.php");
        include_once("./debug.php");
    } else {
        $_SESSION['validation']['checkout'] = 'Field Missing';
        header("Location: checkout.php");
    }
    preShow($_POST);
    preShow($_SESSION);

    // Output helper function
    function preShow($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    }

    // Check credit card helper function
    function check_cc($cc, $extra_check = false){
        $cards = array(
            "visa" => "(4\d{12}(?:\d{3})?)",
            "amex" => "(3[47]\d{13})",
            "jcb" => "(35[2-8][89]\d\d\d{10})",
            "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
            "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
            "mastercard" => "(5[1-5]\d{14})",
            "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
        );
        $names = array("Visa", "American Express", "JCB", "Maestro", "Solo", "Mastercard", "Switch");
        $matches = array();
        $pattern = "#^(?:".implode("|", $cards).")$#";
        $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
        if($extra_check && $result > 0){
            $result = (validatecard($cc))?1:0;
        }
        return ($result>0)?$names[sizeof($matches)-2]:false;
    }

    function validatecard($cardnumber) {
        $cardnumber=preg_replace("/\D|\s/", "", $cardnumber);  # strip any non-digits
        $cardlength=strlen($cardnumber);
        $parity=$cardlength % 2;
        $sum=0;
        for ($i=0; $i<$cardlength; $i++) {
          $digit=$cardnumber[$i];
          if ($i%2==$parity) $digit=$digit*2;
          if ($digit>9) $digit=$digit-9;
          $sum=$sum+$digit;
        }
        $valid=($sum%10==0);
        return $valid;
    }
?>
