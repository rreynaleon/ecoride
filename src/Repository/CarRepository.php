<?php

namespace App\Repository;

use App\Entity\Car;

class CarRepository extends Repository
{
    // Dans ce repository, on interroge la table 'car' de la base de données
    // On récupère les données et on les mappe dans des objets Car

    // Récupéerer une voiture par son ID
    public function find(int $id): ?Car
    {
        try {
            $query = "SELECT * FROM car WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();

            $carData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($carData) {
                return Car::createAndHydrate($carData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de la voiture : " . $e->getMessage());
            return null;
        }
    }

    // Récupérer toutes les voitures
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM car Limit 10";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $carsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $cars = [];
            foreach ($carsData as $car) {
                $cars[] = Car::createAndHydrate($car);
            }

            return $cars;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des voitures : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer une voiture par l'id utilisateur
    public function findByUserId(int $userId): array
    {
        try {
            $query = "SELECT * FROM car WHERE user_id = :user_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();

            $carsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $cars = [];
            foreach ($carsData as $carData) {
                $cars[] = Car::createAndHydrate($carData);
            }
            return $cars;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des voitures par user_id : " . $e->getMessage());
            return [];
        }
    }

    // Enregistrer une voiture (insert)
    public function save(Car $car): bool
    {
        try {
            // Vérifier si la plaque existe déjà
            $queryCheck = "SELECT COUNT(*) FROM car WHERE license_plate = :license_plate";
            $statementCheck = $this->pdo->prepare($queryCheck);
            $statementCheck->bindValue(':license_plate', $car->getLicensePlate(), \PDO::PARAM_STR);
            $statementCheck->execute();
            $exists = $statementCheck->fetchColumn();

            if ($exists > 0) {
                // La plaque existe déjà, on refuse l'insertion
                return false;
            }

            // Insertion si pas de doublon
            $query = "INSERT INTO car (user_id, brand, model, color, fuel_type, license_plate, seats) 
                      VALUES (:user_id, :brand, :model, :color, :fuel_type, :license_plate, :seats)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $car->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':brand', $car->getBrand(), \PDO::PARAM_STR);
            $statement->bindValue(':model', $car->getModel(), \PDO::PARAM_STR);
            $statement->bindValue(':color', $car->getColor(), \PDO::PARAM_STR);
            $statement->bindValue(':fuel_type', $car->getFuelType(), \PDO::PARAM_STR);
            $statement->bindValue(':license_plate', $car->getLicensePlate(), \PDO::PARAM_STR);
            $statement->bindValue(':seats', $car->getSeats(), \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'enregistrement de la voiture : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour une voiture (update)
    public function update(Car $car): bool
    {
        try {
            // Vérifier si la plaque existe déjà
            $queryCheck = "SELECT COUNT(*) FROM car WHERE license_plate = :license_plate AND id != :id";
            $statementCheck = $this->pdo->prepare($queryCheck);
            $statementCheck->bindValue(':license_plate', $car->getLicensePlate(), \PDO::PARAM_STR);
            $statementCheck->bindValue(':id', $car->getId(), \PDO::PARAM_INT);
            $statementCheck->execute();
            $exists = $statementCheck->fetchColumn();

            if ($exists > 0) {
                // La plaque existe déjà pour une autre voiture, on refuse la modification
                return false;
            }

            // Mise à jour si pas de doublon
            $query = "UPDATE car 
                      SET user_id = :user_id, brand = :brand, model = :model, color = :color, 
                          fuel_type = :fuel_type, license_plate = :license_plate, seats = :seats
                      WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $car->getId(), \PDO::PARAM_INT);
            $statement->bindValue(':user_id', $car->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':brand', $car->getBrand(), \PDO::PARAM_STR);
            $statement->bindValue(':model', $car->getModel(), \PDO::PARAM_STR);
            $statement->bindValue(':color', $car->getColor(), \PDO::PARAM_STR);
            $statement->bindValue(':fuel_type', $car->getFuelType(), \PDO::PARAM_STR);
            $statement->bindValue(':license_plate', $car->getLicensePlate(), \PDO::PARAM_STR);
            $statement->bindValue(':seats', $car->getSeats(), \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour de la voiture : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer une voiture
    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM car WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression de la voiture : " . $e->getMessage());
            return false;
        }
    }
}
