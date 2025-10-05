<?php

namespace App\Repository;

use App\Entity\Review;

// TODO: Améliorer la gestion des erreurs et le retour d’erreur utilisateur (exceptions personnalisées, messages, etc.)

class ReviewRepository extends Repository
{
    // Dans ce repository, on interroge la table 'review' de la base de données
    // On récupère les données et on les mappe dans des objets Review

    // Récupéerer une review par son ID
    public function find(int $id): ?Review
    {
        try {
            $query = "SELECT * FROM review WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();

            $reviewData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($reviewData) {
                return Review::createAndHydrate($reviewData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de la review : " . $e->getMessage());
            return null;
        }
    }

    //Lister toutes les reviews
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM review LIMIT 10";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $reviewsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $reviews = [];
            foreach ($reviewsData as $review) {
                $reviews[] = Review::createAndHydrate($review);
            }

            return $reviews;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des reviews : " . $e->getMessage());
            return [];
        }
    }

    // Lister tous les avis d'un utilisateur (reçus)
    public function findByUserIdTarget(int $userIdTarget): array
    {
        try {
            $query = "SELECT * FROM review WHERE user_id_target = :userIdTarget LIMIT 10";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':userIdTarget', $userIdTarget, \PDO::PARAM_INT);
            $statement->execute();

            $reviewsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $reviews = [];
            foreach ($reviewsData as $review) {
                $reviews[] = Review::createAndHydrate($review);
            }

            return $reviews;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des reviews de l'utilisateur cible : " . $e->getMessage());
            return [];
        }
    }

    // Lister tous les avis d'un utilisateur (écrits)
    public function findByUserIdAuthor(int $userIdAuthor): array
    {
        try {
            $query = "SELECT * FROM review WHERE user_id_author = :userIdAuthor LIMIT 10";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':userIdAuthor', $userIdAuthor, \PDO::PARAM_INT);
            $statement->execute();

            $reviewsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $reviews = [];
            foreach ($reviewsData as $review) {
                $reviews[] = Review::createAndHydrate($review);
            }

            return $reviews;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des reviews de l'utilisateur auteur : " . $e->getMessage());
            return [];
        }
    }

    // Lister tous les avis d'un trajet
    public function findByRideId(int $rideId): array
    {
        try {
            $query = "SELECT * FROM review WHERE ride_id = :rideId LIMIT 10";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':rideId', $rideId, \PDO::PARAM_INT);
            $statement->execute();

            $reviewsData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $reviews = [];
            foreach ($reviewsData as $review) {
                $reviews[] = Review::createAndHydrate($review);
            }

            return $reviews;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des reviews du trajet : " . $e->getMessage());
            return [];
        }
    }

    // Ajouter une review
    public function save(Review $review): bool
    {
        try {
            // Vérifier que l'ID n'est pas déjà défini (pour éviter les doublons)
            $queryCheck = "SELECT COUNT(*) FROM review 
                       WHERE user_id_author = :userIdAuthor 
                         AND user_id_target = :userIdTarget 
                         AND ride_id = :rideId";
            $statementCheck = $this->pdo->prepare($queryCheck);
            $statementCheck->bindValue(':userIdAuthor', $review->getUserIdAuthor(), \PDO::PARAM_INT);
            $statementCheck->bindValue(':userIdTarget', $review->getUserIdTarget(), \PDO::PARAM_INT);
            $statementCheck->bindValue(':rideId', $review->getRideId(), \PDO::PARAM_INT);
            $statementCheck->execute();
            $exists = $statementCheck->fetchColumn();

            if ($exists > 0) {
                // Un avis existe déjà pour ce trio (auteur, cible, trajet)
                return false;
            }

            // Insérer la nouvelle review si elle n'existe pas déjà
            $query = "INSERT INTO review (user_id_author, user_id_target, ride_id, rating, comment, date_posted) 
                      VALUES (:userIdAuthor, :userIdTarget, :rideId, :rating, :comment, :datePosted)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':userIdAuthor', $review->getUserIdAuthor(), \PDO::PARAM_INT);
            $statement->bindValue(':userIdTarget', $review->getUserIdTarget(), \PDO::PARAM_INT);
            $statement->bindValue(':rideId', $review->getRideId(), \PDO::PARAM_INT);
            $statement->bindValue(':rating', $review->getRating(), \PDO::PARAM_INT);
            $statement->bindValue(':comment', $review->getComment(), \PDO::PARAM_STR);
            $statement->bindValue(':datePosted', $review->getDatePosted() ? $review->getDatePosted()->format('Y-m-d H:i:s') : null, \PDO::PARAM_STR);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'ajout de la review : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour une review
    public function update(Review $review): bool
    {
        try {
            // Vérifier qu'il n'existe pas déjà un autre avis avec ce trio
            $queryCheck = "SELECT COUNT(*) FROM review 
                       WHERE user_id_author = :userIdAuthor 
                         AND user_id_target = :userIdTarget 
                         AND ride_id = :rideId
                         AND id != :id";
            $statementCheck = $this->pdo->prepare($queryCheck);
            $statementCheck->bindValue(':userIdAuthor', $review->getUserIdAuthor(), \PDO::PARAM_INT);
            $statementCheck->bindValue(':userIdTarget', $review->getUserIdTarget(), \PDO::PARAM_INT);
            $statementCheck->bindValue(':rideId', $review->getRideId(), \PDO::PARAM_INT);
            $statementCheck->bindValue(':id', $review->getId(), \PDO::PARAM_INT);
            $statementCheck->execute();
            $exists = $statementCheck->fetchColumn();

            if ($exists > 0) {
                // Un autre avis existe déjà pour ce trio (auteur, cible, trajet)
                return false;
            }

            // Mettre à jour la review si elle n'existe pas déjà
            $query = "UPDATE review 
                      SET user_id_author = :userIdAuthor, 
                          user_id_target = :userIdTarget, 
                          ride_id = :rideId, 
                          rating = :rating, 
                          comment = :comment, 
                          date_posted = :datePosted
                      WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':userIdAuthor', $review->getUserIdAuthor(), \PDO::PARAM_INT);
            $statement->bindValue(':userIdTarget', $review->getUserIdTarget(), \PDO::PARAM_INT);
            $statement->bindValue(':rideId', $review->getRideId(), \PDO::PARAM_INT);
            $statement->bindValue(':rating', $review->getRating(), \PDO::PARAM_INT);
            $statement->bindValue(':comment', $review->getComment(), \PDO::PARAM_STR);
            $statement->bindValue(':datePosted', $review->getDatePosted() ? $review->getDatePosted()->format('Y-m-d H:i:s') : null, \PDO::PARAM_STR);
            $statement->bindValue(':id', $review->getId(), \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour de la review : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer une review par son ID
    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM review WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression de la review : " . $e->getMessage());
            return false;
        }
    }
}
