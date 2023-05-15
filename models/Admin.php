<?php
namespace models;

use connexion\DataBase;

class Admin extends DataBase {
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function addAdmin($pseudo, $mail, $password)
    {

        
        $stmt = $this->database->prepare("
                                    INSERT INTO admin(
                                                    pseudo,
                                                    mail,
                                                    password
                                                    )
                                    VALUES(?, ?, ?)");
        $test = $stmt->execute([$pseudo, $mail, $password]);
        return $test; // Renvoie true si au moins une ligne a été ajoutée, sinon false

    }
    
    public function getAdminByEmail($mail)
    {
        // Requête pour récupérer l'administrateur par email
        $query = $this->database->prepare("
                                            SELECT
                                                `id`,
                                                `pseudo`,
                                                `mail`,
                                                `password`
                                            FROM
                                                `admin`
                                            WHERE
                                                `mail` = ?
                                                ");
        $query->execute([$mail]);

        // Vérifie si un enregistrement est trouvé
        return $query -> fetch();
    }
    
    public function addProduct($product) {
    // Préparer la requête SQL pour ajouter un nouveau produit
    $query = $this->database->prepare("
                                INSERT INTO product(
                                                    name, 
                                                    description, 
                                                    photo, 
                                                    price) 
                                VALUES (:name, :description, :photo, :price)");
    // Préparer les valeurs pour l'exécution de la requête SQL
    $values = array(
        ':name' => $product['name'],
        ':description' => $product['description'],
        ':photo' => $product['photo'],
        ':price' => $product['price']
    );
    // Exécuter la requête SQL pour ajouter un nouveau produit
        $test = $query->execute($values);
        return $test;
}

}