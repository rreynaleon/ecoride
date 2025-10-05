<?php

namespace App\Repository;

use App\Entity\Role;
use App\Entity\User;

class RoleRepository extends Repository
{
    // Dans ce repository, on interroge la table 'role' de la base de données
    // On récupère les données et on les mappe dans des objets Role

    // Récupéerer un role par son ID
    public function find(int $id): ?Role
    {
        try {
            $query = "SELECT * FROM role WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();

            $roleData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($roleData) {
                return Role::createAndHydrate($roleData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération du rôle : " . $e->getMessage());
            return null;
        }
    }

    //Lister tous les roles
    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM role";
            $statement = $this->pdo->query($query);
            $statement->execute();

            $rolesData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $roles = [];
            foreach ($rolesData as $role) {
                $roles[] = Role::createAndHydrate($role);
            }

            return $roles;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des rôles : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer un rôle par son nom
    public function findByRoleName(string $roleName): ?Role
    {
        try {
            $query = "SELECT * FROM role WHERE role_name = :role_name";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':role_name', $roleName, \PDO::PARAM_STR);
            $statement->execute();

            $roleData = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($roleData) {
                return Role::createAndHydrate($roleData);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération du rôle par nom : " . $e->getMessage());
            return null;
        }
    }

    // Lister tous les utilisateurs d'un rôle spécifique
    public function findUsersbyRole(string $roleName): array
    {
        try {
            $query = "SELECT u.* FROM user u 
            JOIN user_role ur ON u.id = ur.user_id 
            JOIN role r ON ur.role_id = r.id 
            WHERE r.role_name = :role_name";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':role_name', $roleName, \PDO::PARAM_STR);
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

    // Modifier un role
    public function update(Role $role): bool
    {
        try {
            $query = "UPDATE role SET role_name = :role_name WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':role_name', $role->getRoleName(), \PDO::PARAM_STR);
            $statement->bindValue(':id', $role->getId(), \PDO::PARAM_INT);
            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour du rôle : " . $e->getMessage());
            return false;
        }
    }

    //Supprimer un role par son ID
    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM role WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            return $statement->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression du rôle : " . $e->getMessage());
            return false;
        }
    }
}
