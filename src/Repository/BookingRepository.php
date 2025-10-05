<?php

namespace App\Repository;

use App\Entity\Booking;

class BookingRepository extends Repository
{
    // Dans ce repository, on interroge la table 'booking' de la base de données
    // On récupère les données et on les mappe dans des objets Booking

    // Récupéerer une réservation par son ID
    public function find(int $id): ?Booking
    {
        try {
            $query = "SELECT * FROM booking WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();

            $bookingData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($bookingData) {
                return Booking::createAndHydrate($bookingData);
            }

            return null;
            
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de la réservation : " . $e->getMessage());
            return null;
        }
    }


    // Récupérer toutes les réservations
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM booking LIMIT 10";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $bookingsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $bookings = [];
            foreach ($bookingsData as $booking) {
                $bookings[] = Booking::createAndHydrate($booking);
            }

            return $bookings;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des réservations : " . $e->getMessage());
            return [];
        }
    }

    // Lister toutes les réservations faites par un utilisateur
    public function findByUserId(int $userId): array
    {
        try {
            $query = "SELECT * FROM booking WHERE user_id = :user_id LIMIT 10";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();

            $bookingsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $bookings = [];
            foreach ($bookingsData as $booking) {
                $bookings[] = Booking::createAndHydrate($booking);
            }

            return $bookings;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des réservations de l'utilisateur : " . $e->getMessage());
            return [];
        }
    }

    // Lister toutes les réservations pour un trajet donné
    public function findByRideId(int $rideId): array
    {
        try {
            $query = "SELECT * FROM booking WHERE ride_id = :ride_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':ride_id', $rideId, \PDO::PARAM_INT);
            $statement->execute();

            $bookingsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $bookings = [];
            foreach ($bookingsData as $booking) {
                $bookings[] = Booking::createAndHydrate($booking);
            }

            return $bookings;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des réservations pour le trajet : " . $e->getMessage());
            return [];
        }
    }

    // Enregistrer une nouvelle réservation
    public function save(Booking $booking): bool
    {
        try {
            $query = "INSERT INTO booking (ride_id, user_id, places_booked, booking_date, price_total, status) 
                      VALUES (:ride_id, :user_id, :places_booked, :booking_date, :price_total, :status)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':ride_id', $booking->getRideId(), \PDO::PARAM_INT);
            $statement->bindValue(':user_id', $booking->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':places_booked', $booking->getPlacesBooked(), \PDO::PARAM_INT);
            $statement->bindValue(':booking_date', $booking->getBookingDate()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $statement->bindValue(':price_total', $booking->getPriceTotal(), \PDO::PARAM_STR);
            $statement->bindValue(':status', $booking->getStatus(), \PDO::PARAM_STR);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'enregistrement de la réservation : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour une réservation existante
    public function update(Booking $booking): bool
    {
        try {
            $query = "UPDATE booking 
                      SET ride_id = :ride_id, user_id = :user_id, places_booked = :places_booked, 
                          booking_date = :booking_date, price_total = :price_total, status = :status
                      WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $booking->getId(), \PDO::PARAM_INT);
            $statement->bindValue(':ride_id', $booking->getRideId(), \PDO::PARAM_INT);
            $statement->bindValue(':user_id', $booking->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':places_booked', $booking->getPlacesBooked(), \PDO::PARAM_INT);
            $statement->bindValue(':booking_date', $booking->getBookingDate()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $statement->bindValue(':price_total', $booking->getPriceTotal(), \PDO::PARAM_STR);
            $statement->bindValue(':status', $booking->getStatus(), \PDO::PARAM_STR);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour de la réservation : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer une réservation par son ID
    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM booking WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            return $statement->execute();

        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression de la réservation : " . $e->getMessage());
            return false;
        }
    }

}