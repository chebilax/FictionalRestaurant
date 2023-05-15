<?php
namespace controllers;

use models\Admin;
use controllers\SecurityController;

class AdminController extends SecurityController {
    private $admin;
    
    public function __construct()
    {
        $this -> admin = new Admin();
    }

public function admin() {
    // Vérifier si le formulaire de connexion a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer l'email et le mot de passe du formulaire
        $mail = htmlspecialchars($_POST['mail']) ?? '';
        $password = htmlspecialchars($_POST['password']) ?? '';

        // Obtenir l'admin par l'email
        $admin = $this->admin->getadminByEmail($mail);

        if ($admin) {
            // Vérifier si le mot de passe est correct
            if (isset($admin['password']) && password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['admin_pseudo'] = $admin['pseudo'];
                $_SESSION['admin_email'] = $admin['mail'];
                $_SESSION['admin_password'] = $admin['password'];
                header('location:index.php');
                exit();
            } else {
                // Le mot de passe est incorrect
                $message = "Le mot de passe est incorrect.";
            }
        } else {
            // L'adresse mail est incorrecte
            $message = "L'adresse mail est incorrecte.";
        }
    } else {
        $message = "";
    }
    $template = 'admin/homeAdmin';
    require 'www/layout.phtml';
}


    public function addAdmin()
    {
        // Ajoute un nouvel administrateur à la base de données$pseudo = 'admin';
        $pseudo = ''; // Votre pseudo ici
        $mail = ''; // Votre mail ici
        $password = password_hash('admin', PASSWORD_DEFAULT);    
        $admin = new Admin();
        $this->admin->addAdmin($pseudo, $mail, $password);

    }
    
    public function adminLogout()
    {
        session_destroy();
        header('location:index.php');
    }
    
    
}