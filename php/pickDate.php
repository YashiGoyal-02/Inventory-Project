<?php 
// Start the session
session_start();
?>

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

<?php
    // $decide = $_POST['decide'];
    $decide = $_GET['value'];
    $_SESSION['sale_purchase'] = $decide;

    // 0 --> sales
    // 1 --> purchase

    if ($decide == 0) {
        //Sales
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

        <br><br><br>
        <h1 style="color: #2568FB;">Check Your Sales</h1><br><br>
        <?php
    }

    else if ($decide == 1) {
        //Purchase
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
        <br><br><br>
        <h1 style="color: #2568FB;">Check Your Purchases</h1><br><br>
        <?php
    }
?>

        <form action="checkSalePurchase.php" method="post">

            From: <input type="date" name="from" required><br><br>
            To  : <input type="date" name="to" required><br><br>

            <div class="button" style="float: center">
                <button name="check" value=<?php echo htmlspecialchars($decide); ?>>Check !!</button>
			    <button name="reset" type="reset">Reset</button>
            </div>
        </form>


   

</body>
</html> 