 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="http://fonts.googleapis.com/css?family=Dancing Script" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Karla" rel="stylesheet" type="text/css" />
	<link href="css/first.css" rel="stylesheet">
</head>
<!-- <body style="background-color: #eacdbc"> -->
<body style="background-color: #FECD45; font-family: 'Karla'">

	<nav id="navbar" class="navbar order-last order-lg-0">
		<h1 style="color: #2568FB; float: center; font-size: 35px; font-family: 'Dancing Script'">Sales - Purchase - Stock</h1>
        <ul style="float: right;">
          <li><a class="nav-link scrollto active" href="index.php" style="color: black; font-family: 'Karla'">Product Info</a></li>
          <li><a class="nav-link scrollto" href="../Sales_Purchase/sales.php?items=start" style="color: #2568FB; font-family: 'Karla'">Sale Products</a></li>
		  <li><a class="nav-link scrollto" href="../Sales_Purchase/purchase.php?items=start" style="color: #2568FB; font-family: 'Karla'">Purchase Products</a></li>
		  <li><a class="nav-link scrollto" href="../Sales_Purchase/pickDate.php?&value=0" style="color: #2568FB; font-family: 'Karla'">Check Sales</a></li>
		  <li><a class="nav-link scrollto" href="../Sales_Purchase/pickDate.php?&value=1" style="color: #2568FB; font-family: 'Karla'">Check Purchase</a></li>
		  <li><a class="nav-link scrollto" href="stock.php" style="color: #2568FB; font-family: 'Karla'">Check Stocks</a></li>
        </ul>
    </nav>


	<?php

	// database connection
	$mysqli = new mysqli("localhost","root","","salepurchase");

	// Check connection
	if ($mysqli -> connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	exit();
	}
	// echo "success"
	?>
	<center>
	<br><br>
	<h1 style="font-family: 'Karla'">The products available at our outlet are -- <br><br></h1>

	<?php

	$select_sql = "select * from product";


	$result = $mysqli->query($select_sql);
	if ($result->num_rows > 0) {
		?>
		<table class="css-serial" style="color: white">
			<thead>
				<tr>
					<th><center>S.No</center></th>
					<th><center>Product Name</center></th>
					<th><center>Category</center></th>
					<th><center>Price</center></th>
				</tr>
			</thead>

		<?php
		while($row = $result->fetch_assoc()) {
		?>
			<tbody>
				<tr>
					<td><center></center></td>
					<td><center><?php echo $row["name"] ?></center></td>
					<td><center><?php echo $row["category"] ?></center></td>
					<td><center>INR <?php echo $row["price"] ?></center></td>
				</tr>
			</tbody>
			
		<?php
		}
		?>
		</table>
	</center>
		
	<?php
	}
	?>



	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html> 