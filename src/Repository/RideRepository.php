<?php

namespace App\Repository;

use App\Entity\Ride;

class RideRepository extends Repository
{
    // Dans ce repository, on interroge la table 'ride' de la base de données
    // On récupère les données et on les mappe dans des objets Ride

    // Récupéerer un trajet par son ID
    public function find(int $id): ?Ride
    {
        try {
            $query = "SELECT * FROM ride WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();

            $rideData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($rideData) {
                return Ride::createAndHydrate($rideData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération du trajet : " . $e->getMessage());
            return null;
        }
    }

    // Récupérer tous les trajets
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM ride";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $ridesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $rides = [];
            foreach ($ridesData as $ride) {
                $rides[] = Ride::createAndHydrate($ride);
            }

            return $rides;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des trajets : " . $e->getMessage());
            return [];
        }
    }

    // Trouver les trajets par utilisateur
    public function findByUserId(int $userId): array
    {
        try {
            $query = "SELECT * FROM ride WHERE user_id = :user_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();

            $ridesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $rides = [];
            foreach ($ridesData as $ride) {
                $rides[] = Ride::createAndHydrate($ride);
            }

            return $rides;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des trajets par utilisateur : " . $e->getMessage());
            return [];
        }
    }

    // Enregistrer un nouveau trajet
    public function save(Ride $ride): bool
    {
        try {
            $query = "INSERT INTO ride (user_id, car_id, departure_location, departure_date, departure_time, arrival_location, arrival_date, arrival_time, places_available, price, description) 
                      VALUES (:user_id, :car_id, :departure_location, :departure_date, :departure_time, :arrival_location, :arrival_date, :arrival_time, :places_available, :price, :description)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $ride->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':car_id', $ride->getCarId(), \PDO::PARAM_INT);
            $statement->bindValue(':departure_location', $ride->getDepartureLocation(), \PDO::PARAM_STR);
            $statement->bindValue(':departure_date', $ride->getDepartureDate()->format('Y-m-d'), \PDO::PARAM_STR);
            $statement->bindValue(':departure_time', $ride->getDepartureTime()->format('H:i:s'), \PDO::PARAM_STR);
            $statement->bindValue(':arrival_location', $ride->getArrivalLocation(), \PDO::PARAM_STR);
            $statement->bindValue(':arrival_date', $ride->getArrivalDate()->format('Y-m-d'), \PDO::PARAM_STR);
            $statement->bindValue(':arrival_time', $ride->getArrivalTime()->format('H:i:s'), \PDO::PARAM_STR);
            $statement->bindValue(':places_available', $ride->getPlacesAvailable(), \PDO::PARAM_INT);
            $statement->bindValue(':price', $ride->getPrice(), \PDO::PARAM_STR);
            $statement->bindValue(':description', $ride->getDescription(), \PDO::PARAM_STR);

            return $statement->execute();

        } catch (\PDOException $e) {
            error_log("Erreur lors de l'enregistrement du trajet : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour un trajet existant
    public function update(Ride $ride): bool
    {
        try {
            $query = "UPDATE ride SET 
                        user_id = :user_id, 
                        car_id = :car_id, 
                        departure_location = :departure_location, 
                        departure_date = :departure_date, 
                        departure_time = :departure_time, 
                        arrival_location = :arrival_location, 
                        arrival_date = :arrival_date, 
                        arrival_time = :arrival_time, 
                        places_available = :places_available, 
                        price = :price, 
                        description = :description
                      WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $ride->getId(), \PDO::PARAM_INT);
            $statement->bindValue(':user_id', $ride->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':car_id', $ride->getCarId(), \PDO::PARAM_INT);
            $statement->bindValue(':departure_location', $ride->getDepartureLocation(), \PDO::PARAM_STR);
            $statement->bindValue(':departure_date', $ride->getDepartureDate()->format('Y-m-d'), \PDO::PARAM_STR);
            $statement->bindValue(':departure_time', $ride->getDepartureTime()->format('H:i:s'), \PDO::PARAM_STR);
            $statement->bindValue(':arrival_location', $ride->getArrivalLocation(), \PDO::PARAM_STR);
            $statement->bindValue(':arrival_date', $ride->getArrivalDate()->format('Y-m-d'), \PDO::PARAM_STR);
            $statement->bindValue(':arrival_time', $ride->getArrivalTime()->format('H:i:s'), \PDO::PARAM_STR);
            $statement->bindValue(':places_available', $ride->getPlacesAvailable(), \PDO::PARAM_INT);
            $statement->bindValue(':price', $ride->getPrice(), \PDO::PARAM_STR);
            $statement->bindValue(':description', $ride->getDescription(), \PDO::PARAM_STR);

            return $statement->execute();

        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour du trajet : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un trajet
    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM ride WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            return $statement->execute();

        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression du trajet : " . $e->getMessage());
            return false;
        }
    }

    // Chercher des trajets par critères (exemple simple)
    public function search(array $criteria): array
    {
        try {
            $query = "SELECT * FROM ride WHERE 1=1 LIMIT 10"; // Limite pour éviter de ramener trop de résultats
            $params = [];

            if (isset($criteria['departure_location'])) {
                $query .= " AND departure_location = :departure_location";
                $params[':departure_location'] = $criteria['departure_location'];
            }
            if (isset($criteria['arrival_location'])) {
                $query .= " AND arrival_location = :arrival_location";
                $params[':arrival_location'] = $criteria['arrival_location'];
            }
            if (isset($criteria['departure_date'])) {
                $query .= " AND departure_date = :departure_date";
                $params[':departure_date'] = $criteria['departure_date'];
            }

            $statement = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                $statement->bindValue($key, $value, \PDO::PARAM_STR);
            }
            $statement->execute();

            $ridesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $rides = [];
            foreach ($ridesData as $ride) {
                $rides[] = Ride::createAndHydrate($ride);
            }

            return $rides;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la recherche des trajets : " . $e->getMessage());
            return [];
        }
    }

}