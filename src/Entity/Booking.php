<?php

namespace App\Entity;

use DateTimeImmutable;

class Booking extends Entity
{
    // Attributs du futur objet Booking
    protected ?int $id = null;
    protected ?int $rideId = null;
    protected ?int $userId = null;
    protected ?int $placesBooked = null;
    protected ?\DateTimeImmutable $bookingDate = null;
    protected ?float $priceTotal = null;
    protected ?string $status = null;


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

    //$placesBooked
    public function getPlacesBooked(): ?int
    {
        return $this->placesBooked;
    }

    public function setPlacesBooked(?int $placesBooked): self
    {
        $this->placesBooked = $placesBooked;
        return $this;
    }

    //$bookingDate
    public function getBookingDate(): ?\DateTimeImmutable
    {
        return $this->bookingDate;
    }

    public function setBookingDate(?\DateTimeImmutable $bookingDate): self
    {
        if($bookingDate instanceof DateTimeImmutable) {
            $this->bookingDate = $bookingDate;
        } elseif(is_string($bookingDate) && $bookingDate !== null) {
            $this->bookingDate = new DateTimeImmutable($bookingDate);
        } else {
            $this->bookingDate = null;
        }
        return $this;
    }

    //$priceTotal
    public function getPriceTotal(): ?float
    {
        return $this->priceTotal;
    }

    public function setPriceTotal(?float $priceTotal): self
    {
        $this->priceTotal = $priceTotal;
        return $this;
    }

    //$status
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }


}