<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="http://fonts.googleapis.com/css?family=Dancing Script" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Karla" rel="stylesheet" type="text/css" />
	<link href="css/first.css" rel="stylesheet">
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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

<?php

// database connection
$mysqli = new mysqli("localhost","root","","salepurchase");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
// echo "success"

$productId = $_POST['productId'];
$name = $_POST['name'];
$address = $_POST['address'];
$invoice = $_POST['invoice'];
// echo $invoice;
$quantity = $_POST['quantity'];
// $price = $_POST['price'];
$discount = $_POST['discount'];
$value = $_POST['final'];

$price_prod = "select price from product where id=$productId";
$resultPrice = $mysqli->query($price_prod);
$Prod_price = mysqli_fetch_array($resultPrice);
$price = $Prod_price[0];

$finalPrice = ($price - (($price * $discount)/100))*$quantity;


$quan = "select quantity from product where id=$productId";
// echo $quan;
$resultQuan = $mysqli->query($quan);
$ProductQuantity = mysqli_fetch_array($resultQuan);


$prodName = "select name from product where id=$productId";
$resultname = $mysqli->query($prodName);
$ProductName = mysqli_fetch_array($resultname);

if ($quantity > $ProductQuantity[0]) {
	?>
		<h1>Sorry, <?php echo $quantity?> units of <?php echo $ProductName[0] ?> are not available !<br>
			Only <?php echo $ProductQuantity[0] ?> units available.<br>
		</h1>
	<?php
}

else {
	$sql = "insert into sales (productId, customerName, address, invoiceNo, quantity, discount, finalPrice)
        values ('$productId', '$name', '$address', '$invoice', '$quantity', '$discount', $finalPrice)";

	if ($mysqli->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
		 
		 
	$last_id = $mysqli->insert_id;

	$subtract = "UPDATE product SET quantity=quantity-$quantity WHERE id = $productId";

    if ($mysqli->query($subtract) === FALSE) {
        echo "Error updating record: " . $conn->error;
    }

	
	if ($value == 'submit') {
		$total = "select sum(finalPrice) from sales where invoiceNo=$invoice";
		$resultP = $mysqli->query($total);
		$priceT = mysqli_fetch_array($resultP);
		?>
	
		<h1><br>Invoice Number - <?php echo $invoice ?><br></h1>
		<center><h1>Successfully sold<br></h1></center>
		<?php
		$selectProd = "select *, sales.quantity as qut from sales join product on product.id=sales.productId
						where sales.invoiceNo=$invoice";
		$resultP = $mysqli->query($selectProd);
		if ($resultP->num_rows > 0) {
			?>
			<center>
			<table class="css-serial" style="color: white" id="countit">
				<thead>
					<tr>
						<th><center>S.No</center></th>
						<th><center>Product Name</center></th>
						<th><center>Quantity</center></th>
						<th><center>Amount</center></th>
					</tr>
				</thead>

			<?php
			while($row_P = $resultP->fetch_assoc()) {
			?>
				<tbody class="sno" id="sno">
					<tr class="sno" id="sno">
						<center><td class="sno" id="sno"></td></center>
						<td><center><?php echo $row_P["name"] ?></center></td>
						<td><center><?php echo $row_P["qut"] ?></center></td>
						<td><center>INR <?php echo $row_P["finalPrice"] ?></center></td>
					</tr>
				</tbody>
				
			<?php
			}
			?>
			<!-- </table>
			<table> -->
				<tbody>
				<tr>
					<td>Total Amount - </td>
					<td></td>
					<td></td>
					<td>INR <?php echo $priceT[0] ?><br></td>
				</tr>
				</tbody>
			</table>
			</center>
			
		<?php
		}
	}

	else if ($value == 'add') {
		// echo "hi";
		?>
		<h1>Successfully added <?php echo $quantity?> units of <?php echo $ProductName[0] ?> !<br>
			Under Invoice Number - <?php echo $invoice ?><br>
		</h1>

		<?php
		$total = "select sum(finalPrice) from sales where invoiceNo=$invoice";
		$resultP = $mysqli->query($total);
		$priceT = mysqli_fetch_array($resultP);
		?>
		Amount for <?php echo $quantity?> units of <?php echo $ProductName[0] ?> = <?php echo $finalPrice ?><br>
		Total Amount under Invoice Number <?php echo $invoice ?> till now = INR <?php echo $priceT[0] ?><br><br>
		
		<a href="../Sales_Purchase/sales.php?items=add&name=<?php echo $name?>&address=<?php echo $address?>"><button>Add More Items !</button></a>

		<!-- <button name="items" value="continue">Add More Items</button><br><br> -->

		<?php
	}

}
?>

</body>
</html>