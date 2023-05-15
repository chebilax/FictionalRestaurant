<?php
namespace models;

use connexion\DataBase;

class Product extends DataBase
{
    // Toutes les requêtes (select, insert, update, delete)
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function getProducts(): ?array
    {
        $products = null;
        // Lance une requête SELECT
        $query = $this -> database -> prepare('
                                            SELECT
                                                productCode,
                                                `productName`,
                                                `description`,
                                                `price`,
                                                `image`
                                            FROM
                                                `products`
                                        ');

        
        $query -> execute();
        $products = $query -> fetchAll();
        
        return $products;
    }
    
    public function getProductById($productCode) {
    $stmt = $this->database->prepare('
                                    SELECT 
                                        productCode, 
                                        productName, 
                                        description, 
                                        price, 
                                        image 
                                    FROM 
                                        products 
                                    WHERE 
                                        productCode = :productCode
                                        ');
    $stmt->bindParam(':productCode', $productCode);
    $stmt->execute();
    $product = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $product;
    }
    
    public function addProduct($product) {
    // Préparer la requête SQL pour ajouter un nouveau produit
    $query = $this->database->prepare("
                                INSERT INTO products(
                                                    productName, 
                                                    description, 
                                                    image, 
                                                    price) 
                                VALUES (:name, :description, :image, :price)
                                ");
    // Préparer les valeurs pour l'exécution de la requête SQL
    $values = array(
        ':name' => $product['name'],
        ':description' => $product['description'],
        ':image' => $product['image'],
        ':price' => $product['price']
    );
    // Exécuter la requête SQL pour ajouter un nouveau produit
    $query->execute($values);
}

public function updateProduct($productCode, $productName, $description, $price, $image) {
    $query = $this->database->prepare('SELECT image FROM products WHERE productCode = :productCode');
    $query->execute(array(':productCode' => $productCode));
    $current_image = $query->fetch(\PDO::FETCH_ASSOC)['image'];

    if (!empty($image['name'])) {
        $image_name = $image['name'];
        $image_path = 'www/img/products/' . $image_name;
        move_uploaded_file($image['tmp_name'], $image_path);
    } else {
        $image_name = $current_image;
    }

    $query = $this->database->prepare('
                                UPDATE products 
                                SET productCode = :productCode,    
                                    productName = :productName, 
                                    description = :description, 
                                    price = :price, 
                                    image = :image
                                WHERE productCode = :productCode
                                ');
    $values = array(
        ':productCode' => $productCode,
        ':productName' => $productName,
        ':description' => $description,
        ':price' => $price,
        ':image' => $image_name
    );
    $query->execute($values);
}

    
    public function deleteProduct($productCode) {
        $query = $this->database->prepare('
                                    DELETE FROM products 
                                    WHERE productCode = :productCode'
                                    );
        $query->execute(array(':productCode' => $productCode));
    }




}