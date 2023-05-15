<?php
namespace controllers;

use models\User;
use controllers\SecurityController;

class UserController extends SecurityController{
    private $user;
    
    public function __construct()
    {
        $this->user = new User();
    }
    
    public function createAccount() {
        
        // Tester si le formulaire d'inscription a été envoyé
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification si le mail existe déjà dans la base de données
            $mail = $_POST['mail'];
            $user = $this->user->getUserByEmail($mail);
            if ($user) {
                // Le mail existe déjà, afficher un message d'erreur
                $message = "L'adresse mail $mail est déjà enregistrée.";
            } else {
                // Le mail n'existe pas, on récupère les champs du formulaire
                $lastName = htmlspecialchars ($_POST['lastName']);// htmlspecialchars ??
                $firstName = htmlspecialchars ($_POST['firstName']);
                $birthDate = htmlspecialchars ($_POST['birthDate']);
                $adress = htmlspecialchars ($_POST['adress']);
                $city = htmlspecialchars ($_POST['city']);
                $postalCode = htmlspecialchars ($_POST['postalCode']);
                $country = htmlspecialchars ($_POST['country']);
                $phone = htmlspecialchars ($_POST['phone']);
                $mail = htmlspecialchars ($_POST['mail']);
                $password = htmlspecialchars (password_hash($_POST['password'], PASSWORD_DEFAULT)); // Crypter le mot de passe
                
                // Lancement de l'insertion du client dans la base de données
                $result = $this->user->addUser($lastName, $firstName, $birthDate, $adress, $city, $postalCode, $country, $phone, $mail, $password);
                
                // Vérification si l'insertion a été effectuée
                if ($result) {
                    // Affichage du formulaire d'authentification si l'insertion a réussi
                    //include('www/index.php');
                    $message = "Votre compte à bien crée ";
                    header("location:index.php?action=login&message=".$message);
                } else {
                    // Affichage d'un message d'erreur si l'insertion a échoué
                    $message = "Erreur lors de l'insertion du client dans la base de données.";
                }
            }
        }
        // Appel au template pour afficher le formulaire d'inscription
        // include('www/user/createAccount.phtml');
        $template = "user/createAccount";
        require "www/layout.phtml";
    }
    
    public function login() {
    // Vérifier si le formulaire de connexion a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer l'email et le mot de passe du formulaire
        $mail = htmlspecialchars($_POST['mail']) ?? '';
        $password = htmlspecialchars ($_POST['password']) ?? '';

        // Obtenir l'utilisateur par l'email
        $user = $this->user->getUserByEmail($mail);

        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            // session_start();
            $_SESSION['user_id'] = $user['customerNumber'];
            $_SESSION['user_email'] = $user['mail'];
            $_SESSION['user_firstname'] = $user['firstName'];
            $_SESSION['user_lastname'] = $user['lastName'];
            header('location:index.php');
            exit();
        } else {
            // L'email ou le mot de passe est incorrect, afficher un message d'erreur
            $message = "L'adresse mail ou le mot de passe est incorrect.";
        }
    }

    $template = "user/login";
    require "www/layout.phtml";
    }
    
    public function logout()
    {
        session_destroy();
        header('location:index.php?action=login');
    }
}





