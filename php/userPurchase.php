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

$productId = $_POST['productId'];
$name = $_POST['name'];
$address = $_POST['address'];
$invoice = $_POST['invoice'];
// echo $invoice;
$quantity = $_POST['quantity'];
$value = $_POST['final'];
$discount = $_POST['discount'];


if ($value == 'submit') {
    if ($productId != 0){
        $priceSelect = "SELECT price FROM product where id=$productId";
        $resultP = $mysqli->query($priceSelect);
        $price = mysqli_fetch_array($resultP);

        
        $finalPrice = ($price[0] - (($price[0] * $discount)/100))*$quantity;
    
    
        $sql = "insert into purchase (productId, firmName, address, invoiceNo, quantity, discount, finalPrice)
                values ('$productId', '$name', '$address', '$invoice', '$quantity', '$discount', '$finalPrice')";
    
        if ($mysqli->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

        // $ProductPresent = "select * from product where id=$productId";
        // $result = $mysqli->query($ProductPresent);
        // if ($result->num_rows === 1) { 
        // $row = $result->fetch_assoc();
        // $quantity_existing = $row["quantity"];
    
    
        // $prodName = "select name from product where id=$productId";
        // $resultname = $mysqli->query($prodName);
        // $ProductName = mysqli_fetch_array($resultname);
    
        
        $add = "UPDATE product SET quantity=quantity+$quantity WHERE id = $productId";
    
        if ($mysqli->query($add) === FALSE) {
            echo "Error updating record: " . $mysqli->error;
        }
        ?>

        <h1><br>Invoice Number - <?php echo $invoice ?><br></h1>
        <center><h1>Successfully purchased<br></h1></center>
        
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
    
    
    else {
    ?>
        <h1 style="color: grey;">Add the product details -- <br><br></h1>
        <form action="final.php" method="post">
            Name: <input type="text" name="name" required><br><br>
            Category: <input type="text" name="category" required><br><br>
            Price: <input type="text" name="price" required><br><br>
            <input type=hidden name="discount" value=<?php echo $discount?>>
            <input type=hidden name="quantity" value=<?php echo $quantity?>>
            <input type=hidden name="address" value=<?php echo $address?>>
            <input type=hidden name="invoice" value=<?php echo $invoice?>>
            <input type=hidden name="value" value=<?php echo $value?>>
            <div class="button" style="float: center">
                <input type="submit">
                <input type="reset">
            </div>
        </form>
    
    <?php
    
    $_SESSION['id_product_new'] = $productId;
    $_SESSION['new_product_quantity'] = $quantity;
    
    }
}

else if ($value == 'add') {
    if ($productId != 0){
        $priceSelect = "SELECT price FROM product where id=$productId";
        $resultP = $mysqli->query($priceSelect);
        $price = mysqli_fetch_array($resultP);

        $discount = $_POST['discount'];
        $finalPrice = ($price[0] - (($price[0] * $discount)/100))*$quantity;
    
    
        $sql = "insert into purchase (productId, firmName, address, invoiceNo, quantity, discount, finalPrice)
                values ('$productId', '$name', '$address', '$invoice', '$quantity', '$discount', '$finalPrice')";
    
        if ($mysqli->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

        $ProductPresent = "select * from product where id=$productId";
        $resultProd = $mysqli->query($ProductPresent);
        if ($resultProd->num_rows === 1) { 
            $rowProd = $resultProd->fetch_assoc();
            $quantity_existing = $rowProd["quantity"];
        }
        
    
        $prodName = "select name from product where id=$productId";
        $resultname = $mysqli->query($prodName);
        $ProductName = mysqli_fetch_array($resultname);
    
        
        $add = "UPDATE product SET quantity=quantity+$quantity WHERE id = $productId";
    
        if ($mysqli->query($add) === FALSE) {
            echo "Error updating record: " . $mysqli->error;
        }

        ?>

        <h1>Successfully added <?php echo $quantity?> units of <?php echo $ProductName[0] ?> !<br>
        Under Invoice Number - <?php echo $invoice ?><br>
        </h1>

        <?php
        $total = "select sum(finalPrice) from purchase where invoiceNo=$invoice";
        $resultP = $mysqli->query($total);
        $priceT = mysqli_fetch_array($resultP);
        ?>
        <h3>
        Amount for <?php echo $quantity?> units of <?php echo $ProductName[0] ?> = <?php echo $finalPrice ?><br>
        Total Amount under Invoice Number <?php echo $invoice ?> till now = INR <?php echo $priceT[0] ?><br><br>
        </h3>

        <a href="../Sales_Purchase/purchase.php?items=add"><button>Add More Items !</button></a>
    <?php
    }
    
    
    else {
    ?>
        <h1 style="color: grey;">Add the product details -- <br><br></h1>
        <form action="final.php" method="post">
            Name: <input type="text" name="name" required><br><br>
            Category: <input type="text" name="category" required><br><br>
            Price: <input type="text" name="price" required><br><br>
            <input type=hidden name="discount" value=<?php echo $discount?>>
            <input type=hidden name="quantity" value=<?php echo $quantity?>>
            <input type=hidden name="address" value=<?php echo $address?>>
            <input type=hidden name="invoice" value=<?php echo $invoice?>>
            <input type=hidden name="value" value=<?php echo $value?>>
            <div class="button" style="float: center">
                <input type="submit">
                <input type="reset">
            </div>
        </form>
    
    <?php
    
    $_SESSION['id_product_new'] = $productId;
    $_SESSION['new_product_quantity'] = $quantity;
    
    }
    ?>
    

    <?php
}
?>


</body>
</html> 
