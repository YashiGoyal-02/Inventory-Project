<?php 
// Start the session
session_start();
?>


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
          <li><a class="nav-link scrollto" href="../Sales_Purchase/sales.php?items=start" style="color: #2568FB; font-family: 'Karla'">Sale Products</a></li>
		      <li><a class="nav-link scrollto active" href="../Sales_Purchase/purchase.php?items=start" style="color: black; font-family: 'Karla'">Purchase Products</a></li>
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

// $productId = $_SESSION['id_product_new'];
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$discount = $_POST['discount'];
$address = $_POST['address'];
$invoice = $_POST['invoice'];
$value = $_POST['value'];

$flag = 0;
$selAll = "select * from product";
$resultSelAll = $mysqli->query($selAll);
if ($resultSelAll->num_rows > 0) {
  while ($row_All = $resultSelAll->fetch_assoc()) {
      if ($row_All['name'] == $name) {
          $flag = 1;
          break;
      }
  }
}

if ($flag == 0) {
    $sql = "insert into product (name, category, quantity, price)
            values ('$name', '$category', '$quantity', '$price')";

    if ($mysqli->query($sql) === FALSE) {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

$selProd = "select id from product order by id DESC LIMIT 1";
$idProd = $mysqli->query($selProd);
$prodId = mysqli_fetch_array($idProd);
$productId = $prodId[0];
// echo $productId;


$priceSelect = "SELECT price FROM product where id=$productId";
// echo $priceSelect;
$resultPrice = $mysqli->query($priceSelect);
$priceProd = mysqli_fetch_array($resultPrice);
// echo $priceProd[0];

$finalPrice = ($priceProd[0] - (($priceProd[0] * $discount)/100))*$quantity;
    
$sql = "insert into purchase (productId, firmName, address, invoiceNo, quantity, discount, finalPrice)
        values ('$productId', '$name', '$address', '$invoice', '$quantity', '$discount', '$finalPrice')";
    
if ($mysqli->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
 
if ($value == 'add') {
  ?>
  <h1 style="color: grey;">Successfully added <?php echo $quantity?> units of <?php echo $name ?> !<br>
            Under Invoice Number - <?php echo $invoice ?><br><br>
  </h1>
  <a href="../Sales_Purchase/purchase.php?items=add"><button>Add More Items !</button></a>
<?php
}

else if ($value == 'submit') {
?>
    <center><h1 style="color: grey;">Successfully purchased <br></h1></center><br>
    <?php
    
    $selectProd = "select *, purchase.quantity as qut from purchase join product on product.id=purchase.productId
                        where purchase.invoiceNo=$invoice";
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

        $total = "select sum(finalPrice) from purchase where invoiceNo=$invoice";
        $resultP = $mysqli->query($total);
        $priceT = mysqli_fetch_array($resultP);
    
            ?>
           
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
?>
</body>
</html> 
