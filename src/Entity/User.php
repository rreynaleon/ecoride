<?php

namespace App\Entity;

use DateTimeImmutable;

class User extends Entity
{
    // Attributs du futur objet User
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $lastname = null;
    protected ?string $nickname = null;
    protected ?string $email = null;
    protected ?string $password = null;
    protected ?string $phone = null;
    protected ?string $address = null;
    protected ?DateTimeImmutable $birthdate = null;
    protected ?string $profileImage = null;

    
    public function __construct()
    {
        // Le constructeur doit être vide pour hydrater l'objet avec les données de la base de données
    }

    // Getters et Setters

    // $id
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    // $name
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    // $lastname
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    // $nickname
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    // $email
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    // $password
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    // $phone
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    // $address
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    // $birthdate
    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate): self
    {
        if($birthdate instanceof DateTimeImmutable) {
            $this->birthdate = $birthdate;
        } elseif(is_string($birthdate) && $birthdate !== null) {
            $this->birthdate = new DateTimeImmutable($birthdate);
        } else {
            $this->birthdate = null;
        }

        return $this;
    }

    // $profileImage
    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    public function setProfileImage(?string $profileImage): self
    {
        $this->profileImage = $profileImage;
        return $this;
    }


}