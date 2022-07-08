<?php 
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="http://fonts.googleapis.com/css?family=Dancing Script" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Karla" rel="stylesheet" type="text/css" />
	<link href="css/first.css" rel="stylesheet">
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>

<body style="background-color: #FECD45; font-family: 'Karla'">

    <nav id="navbar" class="navbar order-last order-lg-0">
		<h1 style="color: #2568FB; float: center; font-size: 35px; font-family: 'Dancing Script'">Sales - Purchase - Stock</h1>
        <ul style="float: right;">
          <li><a class="nav-link scrollto" href="index.php" style="color: #2568FB; font-family: 'Karla'">Product Info</a></li>
          <li><a class="nav-link scrollto active" href="../Sales_Purchase/sales.php?items=start" style="color: black; font-family: 'Karla'">Sale Products</a></li>
		  <li><a class="nav-link scrollto" href="../Sales_Purchase/purchase.php?items=start" style="color: #2568FB; font-family: 'Karla'">Purchase Products</a></li>
		  <li><a class="nav-link scrollto" href="../Sales_Purchase/pickDate.php?&value=0" style="color: #2568FB; font-family: 'Karla'">Check Sales</a></li>
		  <li><a class="nav-link scrollto" href="../Sales_Purchase/pickDate.php?&value=1" style="color: #2568FB; font-family: 'Karla'">Check Purchase</a></li>
		  <li><a class="nav-link scrollto" href="stock.php" style="color: #2568FB; font-family: 'Karla'">Check Stocks</a></li>
        </ul>
    </nav>
    <br><br><br>
    
 	<h1 style="color: #2568FB;">Sales</h1><br><br>

    <?php 
        // database connection
        $mysqli = new mysqli("localhost","root","","salepurchase");

        // Check connection
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        } 
        // echo "success"

        $invoiceSelect = "SELECT invoiceNo FROM sales ORDER BY id DESC LIMIT 1";
        // echo $invoiceSelect;
        $result = $mysqli->query($invoiceSelect);
        $status = mysqli_fetch_array($result);
        $val = $_GET['items'];

        if ($val == 'start') {
            $invoiceNo = $status[0] + 1;
        }

        else if ($val == 'add') {
            $invoiceNo = $status[0];
            $cusName = $_GET['name'];
            $cusAddress = $_GET['address'];
        }
        // echo $status[0];
        // echo $invoiceNo;
    ?>

	<div class="form1">
		<form action="user.php" method="post">
            Invoice Number: <input type="text" name="invoice" value=<?php echo $invoiceNo ?> readonly><br><br>
		    
            <label for="productId">ProductId :</label>
			<select name="productId" id="productId" required>
			    <option value="" selected disabled>--</option>
    
    <?php

        $productSelect = "select * from product where quantity>0";

        $result = $mysqli->query($productSelect);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
             ?>
                <option value=<?php echo htmlspecialchars($row["id"]); ?>><?php echo $row["name"]?></option>
            <?php
            }
        }
            ?>
            </select><br><br>

        <?php

        if ($val == 'start') {
        ?>
            Customer Name: <input type="text" name="name" required><br><br>
			Address: <input type="text" name="address" required><br><br>
        <?php
        }

        else if ($val == 'add') {
        ?>
            Customer Name: <input type="text" name="name" value=<?php echo $cusName?> required><br><br>
			Address: <input type="text" name="address" value=<?php echo $cusAddress?> required><br><br>
        <?php
        }
        ?>

			
			<!-- Invoice Number: <input type="text" name="invoice" required><br><br> -->
            <label for="quantity" required>Quantity:</label>
            <input type="number" id="quantity" name="quantity" value=0 min="1" max="300"><br><br>
            <!-- Price: <input type="text" name="price" required><br><br> -->
            Discount: <input type="text" name="discount" value=0 required><h4 style="display: inline;"> %</h4><br><br>
            
            <br>
            
			    
            <div class="button" style="float: center">
                
                <button name="final" value="add">Add Item</button><br><br>

                <button name="final" value="submit">Submit</button>
			    <button name="reset" type="reset">Reset</button>
			</div>
            <br><br>

		</form>

            <!-- <button name="add" value=>Add Item</button> -->
        
	</div> 


    <script>
		function myFunction() {
			var quantity = document.getElementById('quantity').value;
			var discount = document.getElementById('discount').value;
			var result = parseInt(quantity)*parseInt(price);
			console.log(quantity);
			console.log(price);
			console.log(result);

			// alert(result);
			
			// var amount = document.getElementById('amount').value(result);

			document.getElementById('amount').value=result;
		}
		
	</script>

</body>
</html> 