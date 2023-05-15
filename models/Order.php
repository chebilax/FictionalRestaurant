<?php
namespace models;

use connexion\DataBase;

class Order extends DataBase {
    private $database;

    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }

    public function addOrder($customerNumber, $date, $total){
        $stmt = $this->database->prepare("
                                    INSERT INTO orders (
                                        customerNumber,
                                        date,
                                        total
                                    )
                                    VALUES (
                                        :customerNumber, 
                                        :date, 
                                        :total)");

        $stmt->execute([
            'customerNumber' => $customerNumber,
            'date' => $date,
            'total' => $total
        ]);

        // Récupération de la clé primaire générée automatiquement
        $orderId = $this->database->lastInsertId();

        return $orderId;
    }
    
    public function addDetailsOrder($orderNumber, $productCode, $productName, $priceEach, $quantity) {
        $stmt = $this->database->prepare("
                                     INSERT INTO orderdetails (
                                        orderNumber, 
                                        productCode, 
                                        name, 
                                        priceEach, 
                                        quantity
                                        )
                                     VALUES (
                                         :orderNumber, 
                                         :productCode, 
                                         :productName, 
                                         :priceEach, 
                                         :quantity)");
        $test = $stmt->execute([
            'orderNumber' => $orderNumber,
            'productCode' => $productCode,
            'productName' => $productName,
            'priceEach' => $priceEach,
            'quantity' => $quantity
        ]);
        
        return $test;
    }
    
    public function getOrderList() 
    {
        $stmt = $this->database->prepare("
                                    SELECT 
                                        orderNumber, 
                                        date, 
                                        total,
                                        customerNumber
                                        FROM orders 
                                        ORDER BY date DESC");
        $stmt->execute();
        $orderList = $stmt->fetchAll();
        return $orderList;
    }
    
    public function getOrderDetails($orderNumber) 
    {
        $stmt = $this->database->prepare("
                                    SELECT
                                        customers.customerNumber,
                                        customers.lastName,
                                        customers.firstName,
                                        customers.birthdate,
                                        customers.adress,
                                        customers.city,
                                        customers.postalCode,
                                        customers.country,
                                        customers.phone,
                                        customers.mail,
                                        customers.password,
                                        orders.orderNumber,
                                        orders.date,
                                        orderdetails.quantity,
                                        orderdetails.priceEach,
                                        orderdetails.productCode,
                                        orderdetails.name
                                    FROM
                                        orders
                                    INNER JOIN 
                                        orderdetails ON orders.orderNumber = orderdetails.orderNumber
                                    INNER JOIN 
                                        customers ON orders.customerNumber = customers.customerNumber
                                    WHERE
                                        orders.orderNumber = :orderNumber"
        );
        $stmt->execute(['orderNumber' => $orderNumber]);
        $orderDetails = $stmt->fetchAll();
        return $orderDetails;
    }

    
    
}
