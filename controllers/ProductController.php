<?php
namespace controllers;

use models\Product;
use controllers\SecurityController;

class ProductController extends SecurityController{
    private $product;
    
    public function __construct()
    {
        $this -> product = new Product();
    }
    
    public function listProducts():void
    {
        $products = $this -> product -> getProducts();
        $template = "index";
        require "www/layout.phtml";
    }
    
    public function addProduct():void 
    {
        if($this -> is_admin())
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $uploads_dir = 'www/img/products';
                if (!empty($_FILES['image']['name'])) { //si le nom de l'image n'est pas vide
                    $tmp_name = $_FILES["image"]["tmp_name"];
                    $image = $_FILES["image"]["name"];
                    move_uploaded_file($tmp_name, "$uploads_dir/$image");
                }
                $product = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'image' => $image,
                    'price' => $_POST['price']
                ];
                $this -> product -> addProduct($product);
                $message = "Produit ajouté avec succès !";
                header('Location: index.php?action=homeAdmin&message='.$message);
            }else{
                $template = "product/createProduct";
                require "www/layout.phtml";
            }
        }
        else 
        {
            header("location:index.php");
            exit();
        }
    }

public function editProduct(): void 
{
    if($this->is_admin())
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
             $product = [
                'productCode' => $_POST['productCode'],
                'productName' => $_POST['productName'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image' => $_FILES['image']
            ];
            $this->product->updateProduct(
                $product['productCode'], 
                $product['productName'], 
                $product['description'], 
                $product['price'],
                $product['image']
            );
            $message = "Produit modifié avec succès !";
            header('Location: index.php?action=adminEdit&message='.$message);
            
            } elseif(array_key_exists('id',$_GET))
            {
                $productCode = $_GET['id'];
                $product = $this->product->getProductById($productCode);
                $template = "admin/adminEditForm";
                require "www/layout.phtml";
            }
            else
            {
                $products = $this->product->getProducts();
                $template = "admin/adminEdit";
                require "www/layout.phtml";
            }
    } else {
        header("location:index.php");
        exit();
    }
}

    public function deleteProduct(): void 
    {
        if($this->is_admin() && array_key_exists('id', $_GET))
        {
            $productCode = $_GET['id'];
            $this->product->deleteProduct($productCode);
            $message = "Produit supprimé avec succès !";
            header('Location: index.php?action=adminEdit&message='.$message);
        } 
        else 
        {
            header("location:index.php");
            exit();
        }
    }



}


