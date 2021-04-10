<?php
 
// start session()
session_start();
 
// include createDb class to connect MySqli Database
require_once ('php/CreateDb.php');
 
// include component file to get functions that render UI
require_once ('./php/component.php');
 
 
// create instance of Createdb class
$database = new CreateDb("Productdb", "Producttb");
 
if (isset($_POST['add'])){
    /// print_r($_POST['product_id']);
    if(isset($_SESSION['cart'])){
 
        // create new array with product_id added in the session cart variable
        $item_array_id = array_column($_SESSION['cart'], "product_id");
 
        // check if post product_id is in the the item_array_id
        if(in_array($_POST['product_id'], $item_array_id)){
            echo "<script>alert('Product is already added in the cart..!')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }else{
 
            // count how many elements are there in the session variable
            $count = count($_SESSION['cart']);
 
            // create an array that can store in the session cart variable
            $item_array = array(
                'product_id' => $_POST['product_id']
            );
 
            // store array in the session cart variable at count index
            $_SESSION['cart'][$count] = $item_array;
        }
 
        // if session is already been started then execute else block
    }else{
 
        // create an array that can store in the session cart variable
        $item_array = array(
                'product_id' => $_POST['product_id']
        );
 
        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
        print_r($_SESSION['cart']);
    }
}
 
 
?>
 
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
 
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
 
<?php require_once ("php/header.php"); ?>
<div class="container">
        <div class="row text-center py-5">
            <?php
            // call getData() method and store database table rows in the result variable
                $result = $database->getData();
 
                // iterate rows
                while ($row = mysqli_fetch_assoc($result)){
                    //  call component() function and create shopping cart base on the database table values.
                    component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
                }
            ?>
        </div>
</div>
 
 
 
 
<!-- Bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>