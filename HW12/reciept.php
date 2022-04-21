<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Reciept</title>
    <style>
        .header {
            height: 100px;
            width: 100%;
            padding-left: 50px;
            font-size: 33px;
            font-weight: bold;
            line-height: 100px;
            text-decoration: underline;
            background-color: pink;
            margin-bottom: 30px;
        }

        .reciept-header {
            font-size: 30px;
            font-weight: bold;
            color: #006699;
            margin-bottom: 10px;
        }

        .reciept-body {
            background-color: #ffffff;
            border: 1px solid #006699;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .order-summary {
            margin-bottom: 30px;
        }

        .order-type {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-items {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .order-totals {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .confirmation-email {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .order-items p {
            text-decoration: underline;
            font-size: 20px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="header">
        Jade Delight
    </div>

    <div class="reciept-body">
        <div class="order-summary">
            <div class="reciept-header">
                Order Reciept
            </div>
            <div class="order-type">
                <?php
                    extract ($_POST);
                    $del_time = $_POST["del_time"];
                    $pick_time = $_POST["pick_time"];
                    $orderType = $_POST["orderType"];
                    $curr_time = time();
                    if ($orderType == "delivery") {
                        $del_time = strtotime("+30 minutes", $curr_time);
                        echo "Your delivery order will be delivered at " . date('h:ia', $del_time) . ".";
                    } else {
                        $pick_time = strtotime("+15 minutes", $curr_time);
                        echo "Your pick order will be ready at " . date('h:ia', $pick_time) . ".";
                    }
                ?>
            </div>
            <div class="order-items">
                <p class="order-header">Order Summary</p>
                <?php
                    extract ($_POST);
                    echo $_POST["quan0"] . " Chicken Chop Suey = $" . $quan0 * 4.5 . "<br>"; 
                    echo $_POST["quan1"] . " Sweet and Sour Pork = $" . $quan1 * 6.25 . "<br>"; 
                    echo $_POST["quan2"] . " Shrimp Lo Mein = $" . $quan2 * 6.25 . "<br>"; 
                    echo $_POST["quan3"] . " Moo Shi Chicken = $" . $quan3 * 7.50 . "<br>"; 
                    echo $_POST["quan4"] . " Fried Rice = $" . $quan4 * 2.85 . "<br>"; 
                ?>
            </div>
            <div class="order-totals">
                <div class="subtotal">
                    <?php
                        extract ($_POST);
                        $subtotal = $quan0 * 4.5 + $quan1 * 6.25 + $quan2 * 6.25 + $quan3 * 7.50 + $quan4 * 2.85;
                        $subtotal = number_format($subtotal, 2, '.', '');
                        echo "Subtotal: $$subtotal";
                    ?>
                </div>
                <div class="tax">
                    <?php
                        extract ($_POST);
                        $tax = $subtotal * 0.0625;
                        $tax = number_format($tax, 2, '.', '');
                        echo "Tax: $$tax";
                    ?>
                </div>
                <div class="total">
                    <?php
                        extract ($_POST);
                        $total = $subtotal + $tax;
                        $total = number_format($total, 2, '.', '');
                        echo "Total: $$total";
                    ?>
                </div>
            </div>

        </div>

        <div class="confirmation-email">
            <?php
                extract ($_POST);
                $email = $_POST["email"];
                echo "Thank you for your order. <br> A confirmation email has been sent to $email.";
                $msg = "Thank you for your order. The total is $$total! \nYour order method is $method and will be completed at " . date('h:ia', $del_time) . "!"; 
                $msg = wordwrap($msg,70);
                mail("$email", "Your Order", $msg); 
            ?>
        </div>
    
</body>
</html>
