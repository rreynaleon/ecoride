<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends Repository
{
    // Dans ce repository, on interroge la table 'user' de la base de données
    // On récupère les données et on les mappe dans des objets User

    // Récupéerer un utilisateur par son ID
    public function find(int $id): ?User
    {
        try {
            $query = "SELECT * FROM user WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();

            $userData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($userData) {
                return User::createAndHydrate($userData);
            }

            return null;
            
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return null;
        }
    }

    // Récupérer tous les utilisateurs
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM user";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $usersData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $users = [];
            foreach ($usersData as $user) {
                $users[] = User::createAndHydrate($user);
            }

            return $users;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer un utilisateur par son email
    public function findByEmail(string $email): ?User
    {
        try {
            $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();

            $userData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($userData) {
                return User::createAndHydrate($userData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur par email : " . $e->getMessage());
            return null;
        }
    }


    // Récupérer un utilisateur par son pseudo
    public function findByNickname(string $nickname): ?User
    {
        try {
            $query = "SELECT * FROM user WHERE nickname = :nickname LIMIT 1";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':nickname', $nickname);
            $statement->execute();

            $userData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($userData) {
                return User::createAndHydrate($userData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur par pseudo : " . $e->getMessage());
            return null;
        }
    }

    // Enregistrer un nouvel utilisateur
    public function save(User $user): bool
    {
        try {

            // Vérifier si l'email ou le pseudo existe déjà
            $queryCheck = "SELECT COUNT(*) FROM user WHERE email = :email OR nickname = :nickname";
            $statementCheck = $this->pdo->prepare($queryCheck);
            $statementCheck->bindValue(':email', $user->getEmail());
            $statementCheck->bindValue(':nickname', $user->getNickname());
            $statementCheck->execute();
            $exists = $statementCheck->fetchColumn();

            if ($exists > 0) {
                // L'utilisateur existe déjà
                return false;
            }

            // Dans le cas que l'utilisateur n'existe pas, on peut l'insérer
            $query = "INSERT INTO user (name, lastname, nickname, email, password, phone, address, birthdate, profile_image)
                      VALUES (:name, :lastname, :nickname, :email, :password, :phone, :address, :birthdate, :profile_image)";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':name', $user->getName());
            $statement->bindValue(':lastname', $user->getLastname());
            $statement->bindValue(':nickname', $user->getNickname());
            $statement->bindValue(':email', $user->getEmail());
            $statement->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT));
            $statement->bindValue(':phone', $user->getPhone());
            $statement->bindValue(':address', $user->getAddress());
            $statement->bindValue(':birthdate', $user->getBirthdate() ? $user->getBirthdate()->format('Y-m-d') : null);
            $statement->bindValue(':profile_image', $user->getProfileImage());

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un utilisateur par son ID
    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM user WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les utilisateurs par rôle
    public function findByRole(string $role): array
    {
        try {
            $query = "SELECT u.* FROM user u
            JOIN user_role ur ON u.id = ur.user_id
            JOIN role r ON ur.role_id = r.id
            WHERE r.role_name = :role";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':role', $role);
            $statement->execute();

            $usersData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $users = [];
            foreach ($usersData as $user) {
                $users[] = User::createAndHydrate($user);
            }

            return $users;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs par rôle : " . $e->getMessage());
            return [];
        }
    }
}
