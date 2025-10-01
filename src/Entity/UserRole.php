<?php

namespace App\Entity;

class UserRole extends Entity
{
    // Attributs du futur objet UserRole
    protected ?int $userId = null;
    protected ?int $roleId = null;

    public function __construct()
    {
        // Le constructeur doit être vide pour hydrater l'objet avec les données de la base de données
    }

    // Getters et Setters

    //$userId
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    //$roleId
    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(?int $roleId): self
    {
        $this->roleId = $roleId;
        return $this;
    }

}
