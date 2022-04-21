<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jade Delight</title>
<style>
	.userInfo label {
		display: inline-block;
		width: 100px;
		text-align: right;
	}

	.totalSection label {
		display: inline-block;
		width: 300px;
		text-align: right;
	}

	.cost-label {
		display: flex;
		color: blue;
	}

    .header {
        height: 100px;
        width: 100%;
        padding-left: 50px;
        font-size: 33px;
        font-weight: bold;
        line-height: 100px;
        text-decoration: underline;
        background-color: pink;
    }

</style>
</head>

<body>
    <script>
    function MenuItem(name, cost)
    {
        this.name = name;
        this.cost=cost;
    }

    menuItems = new Array(
        new MenuItem("Chicken Chop Suey", 4.5),
        new MenuItem("Sweet and Sour Pork", 6.25),
        new MenuItem("Shrimp Lo Mein", 6.25),
        new MenuItem("Moo Shi Chicken", 7.5),
        new MenuItem("Fried Rice", 2.85)
    );

    function updateVals() {
        document.getElementById("street").style.display = "none";
        document.getElementById("city").style.display = "none";

        document.getElementById("pickup-box").addEventListener("change", () => {
            document.getElementById("street").style.display = "none";
            document.getElementById("city").style.display = "none";
        })

        document.getElementById("delivery-box").addEventListener("change", () => {
            document.getElementById("street").style.display = "block";
            document.getElementById("city").style.display = "block";
        })

    }

    function calculateTotals() {

        var priceBoxes = document.getElementsByName("cost");
        var totalCost = 0;

        for (let row = 0; row < menuItems.length; row++) {
            var select = document.getElementsByName("quan" + row);
            var numOrders = select[0].options[select[0].selectedIndex].innerHTML;
            var price = menuItems[row].cost * numOrders;
            totalCost += price;
            priceBoxes[row].value = parseFloat(price).toFixed(2);
        }

        var subtotal = document.getElementById("subtotal");
        var tax = document.getElementById("tax");
        var total = document.getElementById("total");

        subtotal.value = parseFloat(totalCost).toFixed(2);
        tax.value = parseFloat(totalCost * 0.0625).toFixed(2);
        total.value = parseFloat(parseFloat(subtotal.value) + parseFloat(tax.value)).toFixed(2);

    }

    function validate() {
        if (!validateInfo()) {
            return;
        }
        if (validateOrder()) {
            displayOrderWindow();
        }
    }

    function validateInfo() {
        if (validateFormByName("lastName") && validateFormByName("phone")) {
            if (document.getElementById("delivery-box").checked) {
                return validateFormByName("city") && validateFormByName("street");
            }
            return 1;
        } else {
            return 0;
        }
        
    }

    function validateFormByName(name) {
        var val = document.getElementsByName(name)[0].value;

        if (name == "phone") {
            return validatePhone();
        }

        if (val == "") {
            if (name == "lastName") alert("Please fill in last name");
            if (name == "street") alert("Please fill in street");
            if (name == "city") alert("Please fill in city");
            if (name == "email") alert("Please fill in email");
            return 0;
        } else {
            return 1;
        }
    }

    function validatePhone() {
        var val = document.getElementsByName("phone")[0].value;
        var nums = val.replace(/[^0-9]/g,"").length;
        if (nums > 6 && nums < 11) {
            return 1;
        }
        
        alert("Please fill in phone number (7-10 numbers)");
        return 0;
    }

    function validateOrder() {
        var orderedSomething = 0;
        for (let i = 0; i < menuItems.length; i++) {
            var select = document.getElementsByName("quan" + i);
            var numOrders = select[0].options[select[0].selectedIndex].innerHTML;
            if (numOrders != 0) {
                orderedSomething = 1;
            }
        }

        if (!orderedSomething) {
            alert("You can't order nothing, fool.");
            return 0;
        }
        
        return 1;
    }
    
    window.addEventListener('load', updateVals);

    </script>

    <div class="header">
        Jade Delight
    </div>

    <form method="post" action="reciept.php">
        <p class="userInfo"><label>First Name:</label> <input type="text"  name='firstName' /></p>
        <p class="userInfo"><label>Last Name*:</label>  <input type="text"  name='lastName' /></p>
        <p class="userInfo address" id="street"><label>Street*:</label> <input type="text" name='street' /></p>
        <p class="userInfo address" id="city"><label>City*:</label> <input type="text" name='city' /></p>
        <p class="userInfo"><label>Phone*:</label> <input type="text"  name='phone' /></p>
        <p class="userInfo"><label>Email*:</label> <input type="text"  name='email' /></p>
        <p> 
            <input type="radio"  id="pickup-box" name="orderType" value = "pickup" checked="checked"/>Pickup  
            <input type="radio"  id="delivery-box" name='orderType' value = 'delivery'/>
            Delivery
        </p>

        <table border="0" cellpadding="3">
        <tr>
            <th>Select Item</th>
            <th>Item Name</th>
            <th>Cost</th>
            <th>Total Cost</th>
        </tr>

        <!-- Adds each item wih cost and total cost boxes -->
        <?php
            $server = "sql311.epizy.com";
            $userid = "epiz_30921231";
            $pw = "veioxw9b5M";
            $db = "epiz_30921231_Jade_Delight";
    
            $conn = new mysqli($server, $userid, $pw);
            if ($conn->connect_error) {
                die("Connection failed: " . mysqli_connect_error());
            }
    
            
            $conn->select_db($db);
    
            $sql = "SELECT * FROM Dishes";

            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                // write data of each row to table
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><select name='quan" . $row["dishID"] . "' size='1' onchange='calculateTotals()'>";
                    for ($i = 0; $i < 10; $i++) {
                        echo "<option value='" . $i . "'>" . $i . "</option>";
                    }
                    echo "</select></td>";
                    echo "<td class='itemName'>" . $row["dishName"]. "</td>";
                    echo "<td class='cost'>" . $row["Cost"]. "</td>";
                    echo "<td>$<input type='text' name='cost'/></td>";
                    echo "</tr>";
                }
            } 
            $conn->close();
        ?>
        </table>
    
        <p class="subtotal totalSection"><label>Subtotal:</label>
        $ <input type="text"  name='subtotal' id="subtotal" />
        </p>
        <p class="tax totalSection"><label>Mass tax 6.25%:</label>
        $ <input type="text"  name='tax' id="tax" />
        </p>
        <p class="total totalSection"><label>Total:</label> $ <input type="text"  name='total' id="total" />
        </p>

        <input type = "submit" value = "Submit Order"  />
    </form>

</body>
</html>
	
