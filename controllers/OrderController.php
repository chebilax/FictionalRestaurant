<?php
namespace controllers;

use models\Product;
use models\Order;
use controllers\SecurityController;

class OrderController extends SecurityController {
    private $product;
    private $order;
    
    public function __construct()
    {
        $this->product = new Product();
        $this -> order = new Order();
    }
    
    public function order(): void
    {
        // Vérifier que l'utilisateur est connecté
        if (!$this->is_connect()) {
            header("Location: index.php?action=login");
            exit();
        }
        
        // Récupérer les produits
        $products = $this->product->getProducts();
        
        // Charger le template de commande en passant les données des produits
        $template = "order/order";
        require "www/layout.phtml";
    }
    
    public function cmdAjax(): void
    {
                // Vérifier que l'utilisateur est connecté
        if (!$this->is_connect()) {
            header("Location: index.php?action=login");
            exit();
        }
        $productId = $_GET["product_id"] ?? null;
        if ($productId !== null) {
            $productDetails = $this->product->getProductById($productId);
            // var_dump($productDetails);
            header("Content-type: application/json");
            echo json_encode($productDetails);
    }
    }
    
    public function cmdAjax2(): void
    {
        // Vérifier que l'utilisateur est connecté
        if (!$this->is_connect()) {
            header("Location: index.php?action=login");
            exit();
        }
        // Vérifier que les paramètres "product_id", "customer_id", "order" et "total_price" sont envoyés via l'URL
        if (!isset($_GET["total"], $_GET["commande"])) {
            http_response_code(400); // Mauvaise requête
            return;
        }
    
        // Récupérer les données de la commande depuis l'URL
        // $productCode = $_GET["productCode"];
        // $customerNumber = $_GET["customerNumber"];
        $order = json_decode($_GET["commande"], true);
        $totalPrice = $_GET["total"];
        $customerId = $_SESSION['user_id'];
    
        // Insérer la commande dans la base de données
        $date = date("Y-m-d H:i:s");
        $orderId = $this->order->addOrder($customerId, $date, $totalPrice);
    
        // Insérer les détails de la commande dans la base de données
        foreach ($order as $item) {
            // $product = $this->product->getProductById($item["id"]);
            $test = $this->order->addDetailsOrder($orderId, $item["id"], $item["name"], $item["price"], $item["quantity"]);
        }
    
        // Envoyer une réponse en JSON
        $message = "Commande insérée avec succès.";
        header("Content-type: application/json");
        echo json_encode($message);
    }

    public function orderList()
    {
        if ($this->is_admin()) {
            $orderList = $this->order->getOrderList();
            $template = "order/orderList";
            require "www/layout.phtml";
        } else {
            header("location:index.php?action=login");
            exit();
        }
    }
    
    public function orderDetails()
    {
        if ($this->is_admin()) {
            $orderNumber = $_GET['orderNumber'];
            $orderDetails = $this->order->getOrderDetails($orderNumber);
            // var_dump($orderDetails);
            $template = "order/orderDetails";
            require "www/layout.phtml";
        } else {
            header("location:index.php?action=login");
            exit();
        }
    }



}