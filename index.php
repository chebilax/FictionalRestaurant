<?php
session_start();
// les namespace 
// use connexion\DataBase;
use controllers\ProductController;
use controllers\UserController;
use controllers\BookingController;
use controllers\OrderController;
use controllers\AdminController;

//autoload
function chargerClasse($classe)
{
    $classe=str_replace('\\','/',$classe);      
    require $classe.'.php'; 
}

spl_autoload_register('chargerClasse'); //fin Autoload

// Appel aux controleurs
$productController = new ProductController();
$userController = new UserController();
$bookingController = new BookingController();
$orderController = new OrderController();
$adminController = new AdminController();


if(array_key_exists('action',$_GET))
{
    switch($_GET['action'])
    {
        case "createAccount" : 
            $userController -> createAccount();
            break;
        case "login" :
            $userController -> login();
            break;
        case 'logout' : 
            $userController -> logout();
            break;
        case 'booking' :
            $bookingController -> booking();
            break;
        case 'order' :
            $orderController -> order();
            break;
        case 'ajax' :
            $orderController -> cmdAjax();
            break;
        case 'cmdajax' :
            $orderController -> cmdAjax2();
            break;
        case 'addAdmin' :
            $adminController -> addAdmin();
            break;
        case 'admin' :
            $adminController -> admin();
            break;
        case 'adminLogout' :
            $adminController -> adminLogout();
            break;
        case 'homeAdmin' :
            $adminController -> admin();
            break;
        case 'addProduct' :
            $productController -> addProduct();
            break;
        case 'adminEdit' :
            $productController -> editProduct();
            break;
        case 'deleteProduct' :
            $productController -> deleteProduct();
            break;
        case 'bookingList':
            $bookingController-> bookingList();
            break;
        case 'orderList' :
            $orderController -> orderList();
            break;
        case 'orderDetails' :
            $orderController -> orderDetails();
            break;
        case 'deleteBooking' :
            $bookingController -> deleteBooking($reservationNumber);
            break;
    }
}
else
{
    $productController -> listProducts(); // Pour afficher la page d'accueil
}