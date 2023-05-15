<?php
namespace models;

use connexion\DataBase;

class Booking extends DataBase {
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function insertResa($dateTime, $numberPeople,$customerNumber) {
            $stmt = $this->database->prepare("
                                            INSERT INTO booking(
                                                date,
                                                numberPeople,
                                                customerNumber
                                            )
                                            VALUES (:dateTime, :numberPeople,:customerNumber)");
            $stmt->execute([
                'dateTime' => $dateTime,
                'numberPeople' => $numberPeople,
                'customerNumber' => $customerNumber
            ]);
            return true; // La réservation a été ajoutée avec succès
        // }
    }
    
    
    public function getBookingList() 
    {
        $stmt = $this->database->prepare("
                                    SELECT 
                                        reservationNumber,
                                        date, 
                                        numberPeople, 
                                        customerNumber 
                                        FROM booking 
                                        ORDER BY date DESC");
        $stmt->execute();
        $bookingList = $stmt->fetchAll();
        return $bookingList;
    }


public function deleteBooking($reservationNumber) 
{
    $stmt = $this->database->prepare("
                                DELETE FROM booking
                                WHERE reservationNumber = :reservationNumber
    ");
    $stmt->execute(['reservationNumber' => $reservationNumber]);

    return $stmt->rowCount() > 0;
}


public function getCustomerBookingList($customerNumber) 
{
    $stmt = $this->database->prepare("
                                SELECT 
                                    reservationNumber,
                                    date, 
                                    numberPeople, 
                                    customerNumber 
                                    FROM booking 
                                    WHERE customerNumber = :customerNumber 
                                    ORDER BY date DESC");
    $stmt->execute(['customerNumber' => $customerNumber]);
    $bookingList = $stmt->fetchAll();
    return $bookingList;
}



}