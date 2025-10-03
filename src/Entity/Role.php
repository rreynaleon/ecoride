<?php 

namespace App\Entity;

class Role extends Entity
{
    // Attributs du futur objet Role
    protected ?int $id = null;
    protected ?string $roleName = null;

    function __construct()
    {
        // Le constructeur doit être vide pour hydrater l'objet avec les données de la base de données
    }

    // Getters et Setters

    //$id
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    //$roleName
    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(?string $roleName): self
    {
        $this->roleName = $roleName;
        return $this;
    }

}