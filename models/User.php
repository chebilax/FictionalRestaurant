<?php
namespace models;

use connexion\DataBase;

class User extends DataBase
{
   private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }

    public function addUser($lastName, $firstName, $birthDate, $adress, $city, $postalCode, $country, $phone, $mail, $password) {
        $stmt = $this->database->prepare("
                                   INSERT INTO customers(
                                                    lastName,
                                                    firstName,
                                                    birthDate,
                                                    adress,
                                                    city,
                                                    postalCode,
                                                    country,
                                                    phone,
                                                    mail,
                                                    password
                                                )
                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
        $test = $stmt->execute([$lastName, $firstName, $birthDate, $adress, $city, $postalCode, $country, $phone, $mail, $password]);
        return $test; // Renvoie true si au moins une ligne a été ajoutée, sinon false
    }

    public function getUserByEmail($mail) {
        $stmt = $this->database->prepare('
                                    SELECT
                                        `customerNumber`,
                                        `lastName`,
                                        `firstName`,
                                        `birthDate`,
                                        `adress`,
                                        `city`,
                                        `postalCode`,
                                        `country`,
                                        `phone`,
                                        `mail`,
                                        `password`
                                        FROM
                                        `customers`
                                    WHERE mail = ?');
        $stmt->execute([$mail]);
        return $stmt->fetch(); 
    }
}
