<?php

namespace App\Entity;

use DateTimeImmutable;

class Review extends Entity
{
    // Attributs du futur objet Review
    protected ?int $id = null;
    protected ?int $userIdAuthor = null;
    protected ?int $userIdTarget = null;
    protected ?int $rideId = null;
    protected ?int $rating = null;
    protected ?string $comment = null;
    protected ?\DateTimeImmutable $datePosted = null;

    public function __construct()
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

    //$userIdAuthor
    public function getUserIdAuthor(): ?int
    {
        return $this->userIdAuthor;
    }

    public function setUserIdAuthor(?int $userIdAuthor): self
    {
        $this->userIdAuthor = $userIdAuthor;
        return $this;
    }

    //$userIdTarget
    public function getUserIdTarget(): ?int
    {
        return $this->userIdTarget;
    }

    public function setUserIdTarget(?int $userIdTarget): self
    {
        $this->userIdTarget = $userIdTarget;
        return $this;
    }

    //$rideId
    public function getRideId(): ?int
    {
        return $this->rideId;
    }

    public function setRideId(?int $rideId): self
    {
        $this->rideId = $rideId;
        return $this;
    }

    //$rating
    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    //$comment
    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    //$datePosted
    public function getDatePosted(): ?\DateTimeImmutable
    {
        return $this->datePosted;
    }

    public function setDatePosted(?\DateTimeImmutable $datePosted): self
    {
        if($datePosted instanceof DateTimeImmutable) {
            $this->datePosted = $datePosted;
        } elseif(is_string($datePosted) && $datePosted !== null) {
            $this->datePosted = new DateTimeImmutable($datePosted);
        } else {
            $this->datePosted = null;
        }
        return $this;
    }


}