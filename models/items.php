<?php 
    class items {
        private $conn;
        private $table = "items";

        public $itemID;
        public $itemName;
        public $itemPrice;
        public $discountCode;
        public $discountPrice;
        public $discountAmount;
        public $price;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT
                    d.discount as discount,
                    i.itemID,
                    i.itemname,
                    i.itemPrice,
                    i.discountCode
                FROM
                    ' . $this->table . ' i
                LEFT JOIN
                    discounts d ON i.discountCode = d.discountCode
                ORDER BY
                    i.itemID';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_specific() {
            $query = 'SELECT
                    d.discount as discount,
                    i.itemID,
                    i.itemName,
                    i.itemPrice,
                    i.discountCode
                FROM
                    ' . $this->table . ' i
                LEFT JOIN
                    discounts d ON i.discountCode = d.discountCode
                WHERE
                    i.itemID = ?
                LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->itemID);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->itemID = $row['itemID'];
            $this->itemName = $row['itemName'];
            $this->itemPrice = $row['itemPrice'];
            $this->discountCode = $row['discountCode'];
            $this->discount = $row['discount'];
        }

        public function discount_calculation(float $itemPrice,int $discount) {
            $discountPrice = $itemPrice-(($discount * $itemPrice)/100);

            return $discountPrice;
        }
    }
?>