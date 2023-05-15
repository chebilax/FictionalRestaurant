<?php
namespace controllers;

use models\Booking;
use controllers\SecurityController;

class BookingController extends SecurityController{
    public function __construct()
    {
        $this->booking = new Booking();
    }
    
public function booking() 
{
    if($this -> is_connect())
    {
        $customerNumber = $_SESSION['user_id'];

        // Récupérer les réservations effectives de l'utilisateur
        $customerBookingList = $this->booking->getCustomerBookingList($customerNumber);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données du formulaire
            $dateTime = htmlspecialchars($_POST['bookingDate'] . ' ' . $_POST['bookingTime'] .':00');
            $numberPeople = htmlspecialchars($_POST['numberPeople']);

            // Insérer la réservation dans la base de données
            if ($this->booking->insertResa($dateTime, $numberPeople,$customerNumber)) {
                // La réservation a été ajoutée avec succès
                // Rediriger vers une page de confirmation
                $message = "Votre réservation a bien été prise le " . date('d-m-Y H:i', strtotime($dateTime)) . " pour $numberPeople personne(s)";
                header('location:index.php?action=booking&message='.$message);
                exit();
            } else {
                // La table est déjà réservée pour cette date et cette heure
                // Afficher un message d'erreur
                $message = "La table est déjà réservée pour cette date et cette heure.";
            }
        }

        // Afficher le formulaire de réservation et les réservations effectives de l'utilisateur
        $template = "booking/booking";
        require "www/layout.phtml";
    }
    else
    {
        header("location:index.php?action=login");
        exit();
    }
}

    public function bookingList()
    {
        if ($this->is_admin()) {
            $bookingList = $this->booking->getBookingList();
            $template = "booking/bookingList";
            require "www/layout.phtml";
        } else {
            header("location:index.php?action=login");
            exit();
        }
    }

public function deleteBooking()
{
    if ($this->is_admin() && isset($_GET['reservationNumber'])) {
        $reservationNumber = $_GET['reservationNumber'];

        if ($this->booking->deleteBooking($reservationNumber)) {
            $message = "La réservation a été supprimée avec succès.";
            header('Location: index.php?action=bookingList&message=' . $message);
        } else {
            $message = "Une erreur est survenue lors de la suppression de la réservation.";
            header('Location: index.php?action=bookingList&message=' . $message);
        }
    } else {
        header("Location: index.php?action=login");
        exit();
    }
}

    
}