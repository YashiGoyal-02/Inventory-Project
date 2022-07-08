<html>

<head>
  <style>
      table, th, td {
        border: 2px solid white;
        border-collapse: collapse;
        padding: 15px;
      }
      th, td {
        background-color: #96D4D4;
      }

      .css-serial {
        counter-reset: serial-number;  /* Set the serial number counter to 0 */
      }

      .css-serial td:first-child:before {
        counter-increment: serial-number;  /* Increment the serial number counter */
        content: counter(serial-number);  /* Display the counter */
      }
  </style>

  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="http://fonts.googleapis.com/css?family=Dancing Script" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Karla" rel="stylesheet" type="text/css" />
	<link href="css/first.css" rel="stylesheet">

</head>



<body style="background-color: #FECD45; font-family: 'Karla'">
<?php
// database connection
$mysqli = new mysqli("localhost","root","","salepurchase");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
// echo "success"

$value = $_POST['check'];
// 0 --> sales
// 1 --> purchase
if ($value == 0) { //Check Sales
  ?>
  <nav id="navbar" class="navbar order-last order-lg-0">
		<h1 style="color: #2568FB; float: center; font-size: 35px; font-family: 'Dancing Script'">Sales - Purchase - Stock</h1>
        <ul style="float: right;">
          <li><a class="nav-link scrollto" href="index.php" style="color: #2568FB; font-family: 'Karla'">Product Info</a></li>
          <li><a class="nav-link scrollto" href="../Sales_Purchase/sales.php?items=start" style="color: #2568FB; font-family: 'Karla'">Sale Products</a></li>
		      <li><a class="nav-link scrollto" href="../Sales_Purchase/purchase.php?items=start" style="color: #2568FB; font-family: 'Karla'">Purchase Products</a></li>
          <li><a class="nav-link scrollto active" href="../Sales_Purchase/pickDate.php?&value=0" style="color: black; font-family: 'Karla'">Check Sales</a></li>
          <li><a class="nav-link scrollto" href="../Sales_Purchase/pickDate.php?&value=1" style="color: #2568FB; font-family: 'Karla'">Check Purchase</a></li>
          <li><a class="nav-link scrollto" href="stock.php" style="color: #2568FB; font-family: 'Karla'">Check Stocks</a></li>
        </ul>
  </nav>
  <?php
}

else if ($value == 1) {//Check Purchase
  ?>
  <nav id="navbar" class="navbar order-last order-lg-0">
		<h1 style="color: #2568FB; float: center; font-size: 35px; font-family: 'Dancing Script'">Sales - Purchase - Stock</h1>
        <ul style="float: right;">
          <li><a class="nav-link scrollto" href="index.php" style="color: #2568FB; font-family: 'Karla'">Product Info</a></li>
          <li><a class="nav-link scrollto" href="../Sales_Purchase/sales.php?items=start" style="color: #2568FB; font-family: 'Karla'">Sale Products</a></li>
		      <li><a class="nav-link scrollto" href="../Sales_Purchase/purchase.php?items=start" style="color: #2568FB; font-family: 'Karla'">Purchase Products</a></li>
          <li><a class="nav-link scrollto" href="../Sales_Purchase/pickDate.php?&value=0" style="color: #2568FB; font-family: 'Karla'">Check Sales</a></li>
          <li><a class="nav-link scrollto active" href="../Sales_Purchase/pickDate.php?&value=1" style="color: black; font-family: 'Karla'">Check Purchase</a></li>
          <li><a class="nav-link scrollto" href="stock.php" style="color: #2568FB; font-family: 'Karla'">Check Stocks</a></li>
        </ul>
  </nav>
  <?php
}

$from = $_POST['from'];
$to = $_POST['to'];

if ($value == 0) {

    $val = "Sale";
    ?>

    <center>
    <br><br><br>
    <h1 style="color: grey;">The sales of your company between <?php echo date('d M, Y', strtotime($from))?> and <?php echo date('d M, Y', strtotime($to))?> are -- <br></h1>
    <br><br>
    <?php

        $select_sql = "select * from sales where DATE_FORMAT(saleDate, '%Y-%m-%d') between '$from' and '$to'";
}

else if ($value == 1) {

    $val = "Purchase";
    ?>

    <center>
    <br><br><br>
    <h1 style="color: grey;">The purchases of your company between <?php echo date('d M, Y', strtotime($from))?> and <?php echo date('d M, Y', strtotime($to))?> are -- <br></h1>
    <br><br>
    <?php

        $select_sql = "select * from purchase where DATE_FORMAT(purchaseDate, '%Y-%m-%d') between '$from' and '$to'";
}


$result = $mysqli->query($select_sql);
if ($result->num_rows > 0) {
 	?>
 	<table class="css-serial" style="color: white">
		<thead>
			<tr>
				<th><center>S.No</center></th>
                <th><center>Invoice Number</center></th>
                <th><center><?php echo $val?> ID</center></th>
				<th><center>Product ID</center></th>
        <?php
            if ($value == 0) {
                ?>
                <th><center>Customer Name</center></th>
                <?php

            }

            else if ($value == 1) {
                ?>
                <th><center>Firm Name</center></th>
                <?php

            }
        ?>
				<th><center><?php echo $val?> Date</center></th>
				<th><center>Address</center></th>
                <th><center>Quantity</center></th>
                <th><center>Final Price</center></th>
			</tr>
		</thead>

 	<?php
 	while($row = $result->fetch_assoc()) {
 	?>
	 	<tbody>
			<tr>
				<td><center></center></td>
				<td><center><?php echo $row["invoiceNo"] ?></center></td>
				<td><center><?php echo $row["id"] ?></center></td>
				<td><center><?php echo $row["productId"] ?></center></td>
        
        <?php
            if ($value == 0) {
                ?>
                <td><center><?php echo $row["customerName"] ?></center></td>
                <td><center><?php echo $row["saleDate"] ?></center></td>
                <?php
            }

            else if ($value == 1) {
                ?>
                <td><center><?php echo $row["firmName"] ?></center></td>
                <td><center><?php echo $row["purchaseDate"] ?></center></td>
                <?php

            }
        ?>
                <td><center><?php echo $row["address"] ?></center></td>
                <td><center><?php echo $row["quantity"] ?> units</center></td>
                <td><center>INR <?php echo $row["finalPrice"] ?></center></td>
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

</body>
</html> 
