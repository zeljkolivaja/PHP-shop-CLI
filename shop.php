<?php

/* set the array for the products and shopping cart and stage variable so we can check
in which stage the app is */

$products = [];
$shoppingCart = [];
$stage = null;

//loop the application while the $stage == 2
do {

    //get the user input and extract it to array so we can assign it to parameters
    $selection = fgets(STDIN);
    $arguments = explode(" ", $selection);
    $command = trim($arguments[0]);
    $sku = isset($arguments[1]) ? trim($arguments[1]) : null;

    /*if the user sent ADD command and the if the $stage == null it means we are
    in the adding products stage, and the user is allowed to enter products */
    if ($command == "ADD" && $stage == null) {

        if (count($arguments) !== 5) {
            echo "wrong number of parameters";
            echo "\n";

        } else {

            $name = isset($arguments[2]) ? trim($arguments[2]) : null;
            $quantity = isset($arguments[3]) ? trim($arguments[3]) : null;
            $price = isset($arguments[4]) ? trim($arguments[4]) : null;

            if (!isset($products[$sku])) {
                $newProduct = ["sku" => $sku, "name" => $name, "quantity" => $quantity, "price" => $price];
                $products[$sku] = $newProduct;
            } else {
                echo "product already exists";
                echo "\n";
            }

        }

        /* when the user enters END command the first time he is sent to shopping cart stage
    when the user enters END command second time app is closed */
    } elseif ($command == "END") {
        if (isset($stage) && $stage == 1) {
            $stage = 2;
        } else {
            $stage = 1;
        }

        /* if the user enters ADD command while in shopping cart stage (1) he is adding products
    to the $shoppingCart array */
    } elseif ($command == "ADD" && $stage == 1) {

        if (count($arguments) !== 3) {
            echo "wrong number of parameters";
            echo "\n";
        } else {
            $quantity = isset($arguments[2]) ? trim($arguments[2]) : null;
        }

        /* first check do we have enough products then
        if the $shoppingCart array is empty add the product to it,
        if its not empty check does the product already exists, if it does update its quantity,
        if the product is not found within $shoppingCart insert it */

        if (!isset($products[$sku])) {
            echo "requested product does not exist";
            echo "\n";

        } elseif ($products[$sku]["quantity"] - $quantity >= 0) {

            if (empty($shoppingCart)) {

                $newProduct = ["sku" => $sku, "quantity" => $quantity];
                $shoppingCart[$sku] = $newProduct;
            } else {
                $skuS = array_column($shoppingCart, 'sku');
                if (in_array($sku, $skuS)) {

 
                    $tempProductNumber =  $shoppingCart[$sku]["quantity"] + $quantity;


                    if ($tempProductNumber > $products[$sku]["quantity"]) {
                        echo "not enough products availible";
                    } else {
                        $newQUantity = $shoppingCart[$sku]["quantity"] + $quantity;
                        $shoppingCart[$sku]["quantity"] = $newQUantity;
                    }

                } else {
                    $newProduct = ["sku" => $sku, "quantity" => $quantity];
                    $shoppingCart[$sku] = $newProduct;
                }
            }
        } else {
            echo "not enough products availible";
            echo "\n";
        }

        /* if the command REMOVE is entered ($stage must be 1) we check does the product exist in
    the $shoppingCart if it do we update its quantity, if it doesnt exist we display the error,
    if the user is trying to remove more products then he added we set the quantity to 0  */
    } elseif ($command == "REMOVE" && $stage == 1) {

        if (count($arguments) !== 3) {
            echo "wrong number of parameters";
            echo "\n";
        }

        $quantity = isset($arguments[2]) ? trim($arguments[2]) : null;
        $skuS = array_column($shoppingCart, 'sku');

        if (in_array($sku, $skuS)) {
            $newQUantity = $shoppingCart[$sku]["quantity"] - $quantity;
            if ($newQUantity <= 0) {
                $newQUantity = 0;
            }

            $shoppingCart[$sku]["quantity"] = $newQUantity;

        } else {
            echo "No such product in the shopping cart";
            echo "\n";
        }

        /* if the command is CHECKOUT and the stage==1 we get all the products from the $shoppingCart,
    then we match them with $products array to get the rest of the data, we calculate the bill
    and empty the shopping cart   */
    } elseif ($command == "CHECKOUT" && $stage == 1) {

        foreach ($shoppingCart as $key => $value) {

            $quantity = $value["quantity"];
            $productSKU = $value["sku"];

            $name = $products[$productSKU]["name"];
            $price = $products[$productSKU]["price"];

            $newProductsQuantity = $products[$productSKU]["quantity"] - $quantity;

            $products[$productSKU]["quantity"] = $newProductsQuantity;

            $productPrice = $quantity * $price;

            if ($quantity > 0) {
                echo $name . " " . $price . " * " . $quantity . " = " . $productPrice;
                echo "\n";
            }

        }
        $shoppingCart = [];

    } else {

        echo "please insert valid command";
        echo "\n";
    }

} while (strcmp(strval($stage), "2") !== 0);

exit(0);