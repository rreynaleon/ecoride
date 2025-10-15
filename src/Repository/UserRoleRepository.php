<?php

namespace App\Repository;

use App\Entity\UserRole;

class UserRoleRepository extends Repository
{
    // Dans cette classe, on interroge la table 'user_role' de la base de données
    // On récupère les données et on les mappe dans des objets UserRole

    // Récupérer toutes les associations utilisateur-role
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM user_role LiMIT 10";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $userRolesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $userRoles = [];
            foreach ($userRolesData as $userRole) {
                $userRoles[] = UserRole::createAndHydrate($userRole);
            }

            return $userRoles;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des associations utilisateur-rôle : " . $e->getMessage());
            return [];
        }
    }


    // Afficher tous les roles d'un utilisateur par son ID
    public function findRolesByUserId(int $userId): array
    {
        try {
            $query = "SELECT * FROM user_role WHERE user_id = :user_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();

            $userRolesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $userRoles = [];
            foreach ($userRolesData as $userRole) {
                $userRoles[] = UserRole::createAndHydrate($userRole);
            }
            return $userRoles;

        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des rôles de l'utilisateur : " . $e->getMessage());
            return [];
        }
    }

    // Afficher tous les utilisateurs ayant un certain role
    public function findUsersByRoleId(int $roleId): array
    {
        try {
            $query = "SELECT * FROM user_role WHERE role_id = :role_id LiMIT 10";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':role_id', $roleId, \PDO::PARAM_INT);
            $statement->execute();

            $userRolesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $userRoles = [];
            foreach ($userRolesData as $userRole) {
                $userRoles[] = UserRole::createAndHydrate($userRole);
            }

            return $userRoles;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs avec le rôle spécifié : " . $e->getMessage());
            return [];
        }
    }

    // Associer un rôle à un utilisateur
    public function addRoleToUser(int $userId, int $roleId): bool
    {
        try {
            // Vérifier si l'association existe déjà
            $queryCheck = "SELECT COUNT(*) FROM user_role WHERE user_id = :user_id AND role_id = :role_id";
            $statementCheck = $this->pdo->prepare($queryCheck);
            $statementCheck->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statementCheck->bindValue(':role_id', $roleId, \PDO::PARAM_INT);
            $statementCheck->execute();
            $exists = $statementCheck->fetchColumn();

            if ($exists > 0) {
                // L'association existe déjà, on refuse l'insertion
                return false;
            }

            // Si l'association n'existe pas, on l'ajoute
            $query = "INSERT INTO user_role (user_id, role_id) VALUES (:user_id, :role_id)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->bindValue(':role_id', $roleId, \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'ajout du rôle à l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Remover a role from a user
    public function removeRoleFromUser(int $userId, int $roleId): bool
    {
        try {
            $query = "DELETE FROM user_role WHERE user_id = :user_id AND role_id = :role_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->bindValue(':role_id', $roleId, \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression du rôle de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    //Supprimer toutes les associations d'un utilisateur
    public function removeAllRolesFromUser(int $userId): bool
    {
        try {
            $query = "DELETE FROM user_role WHERE user_id = :user_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression des rôles de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Vérifier si un utilisateur a un rôle spécifique
    public function userHasRole(int $userId, int $roleId): bool
    {
        try {
            $query = "SELECT COUNT(*) FROM user_role WHERE user_id = :user_id AND role_id = :role_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->bindValue(':role_id', $roleId, \PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la vérification du rôle de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer une association précise par userId et roleId
    public function findByUserIdAndRoleId(int $userId, int $roleId): ?UserRole
    {
        try {
            $query = "SELECT * FROM user_role WHERE user_id = :user_id AND role_id = :role_id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
            $statement->bindValue(':role_id', $roleId, \PDO::PARAM_INT);
            $statement->execute();

            $data = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($data) {
                return UserRole::createAndHydrate($data);
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de l'association utilisateur-rôle : " . $e->getMessage());
            return null;
        }
    }
}
