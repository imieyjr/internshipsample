<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/items.php';

    $database = new Database();
    $db = $database->connect();

    $items = new items($db); 

    $items->itemID = isset($_GET['itemID']) ? $_GET['itemID'] : die();

    $items->read_specific();

    $price = $items->itemPrice;
    $discountAmount = $items->discount;

    $discount_price = $items->discount_calculation($price,$discountAmount);

    $items_arr = array(
        'DiscountCode' => $items->discountCode,
        'DiscountPrice' => $discount_price,
        'ItemID' => $items->itemID,
        'ItemName' => $items->itemName,
        'ItemPrice' => $items->itemPrice
    );

    print_r(json_encode($items_arr));
    
    ?>