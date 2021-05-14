<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/items.php';

    $database = new Database();
    $db = $database->connect();

    $items = new items($db);

    $result = $items->read();

    $num = $result->rowCount();

    if($num > 0){
        $items_arr = array();
        $items_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $discount_price = $items->discount_calculation($itemPrice,$discount);

            $items_list = array(
                'DiscountCode' => $discountCode,
                'DiscountPrice' => $discount_price,
                'ItemID' => $itemID,
                'ItemName' => $itemname,
                'ItemPrice' => $itemPrice
            );

            array_push($items_arr['data'], $items_list);
        }

        echo json_encode($items_arr);

    } else {
        echo json_encode(
            array('message' => 'No items')
        );
    }
?>