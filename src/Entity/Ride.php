<?php

namespace App\Entity;

use DateTimeImmutable;

class Ride extends Entity
{
    //Attributs du futur objet Ride
    protected ?int $id = null;
    protected ?int $userId = null;
    protected ?int $carId = null;
    protected ?string $departureLocation = null;
    protected ?\DateTimeImmutable $departureDate = null;
    protected ?\DateTimeImmutable $departureTime = null;
    protected ?string $arrivalLocation = null;
    protected ?\DateTimeImmutable $arrivalDate = null;
    protected ?\DateTimeImmutable $arrivalTime = null;
    protected ?int $placesAvailable = null;
    protected ?float $price = null;
    protected ?string $description = null;

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

    //$carId
    public function getCarId(): ?int
    {
        return $this->carId;
    }

    public function setCarId(?int $carId): self
    {
        $this->carId = $carId;
        return $this;
    }

    //$departureLocation
    public function getDepartureLocation(): ?string
    {
        return $this->departureLocation;
    }

    public function setDepartureLocation(?string $departureLocation): self
    {
        $this->departureLocation = $departureLocation;
        return $this;
    }

    //$departureDate
    public function getDepartureDate(): ?\DateTimeImmutable
    {
        return $this->departureDate;
    }

    public function setDepartureDate($departureDate): self
    {
        if($departureDate instanceof DateTimeImmutable) {
            $this->departureDate = $departureDate;
        } elseif(is_string($departureDate) && $departureDate !== null) {
            $this->departureDate = new DateTimeImmutable($departureDate);
        } else {
            $this->departureDate = null;
        }
        return $this;
    }

    //$departureTime
    public function getDepartureTime(): ?\DateTimeImmutable
    {
        return $this->departureTime;
    }

    public function setDepartureTime($departureTime): self
    {
        if($departureTime instanceof DateTimeImmutable) {
            $this->departureTime = $departureTime;
        } elseif(is_string($departureTime) && $departureTime !== null) {
            $this->departureTime = new DateTimeImmutable($departureTime);
        } else {
            $this->departureTime = null;
        }
        return $this;
    }

    //$arrivalLocation
    public function getArrivalLocation(): ?string
    {
        return $this->arrivalLocation;
    }

    public function setArrivalLocation(?string $arrivalLocation): self
    {
        $this->arrivalLocation = $arrivalLocation;
        return $this;
    }

    //$arrivalDate
    public function getArrivalDate(): ?\DateTimeImmutable
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?\DateTimeImmutable $arrivalDate): self
    {
        if($arrivalDate instanceof DateTimeImmutable) {
            $this->arrivalDate = $arrivalDate;
        } elseif(is_string($arrivalDate) && $arrivalDate !== null) {
            $this->arrivalDate = new DateTimeImmutable($arrivalDate);
        } else {
            $this->arrivalDate = null;
        }
        return $this;
    }

    //$arrivalTime
    public function getArrivalTime(): ?\DateTimeImmutable
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime($arrivalTime): self
    {
        if($arrivalTime instanceof DateTimeImmutable) {
            $this->arrivalTime = $arrivalTime;
        } elseif(is_string($arrivalTime) && $arrivalTime !== null) {
            $this->arrivalTime = new DateTimeImmutable($arrivalTime);
        } else {
            $this->arrivalTime = null;
        }
        return $this;
    }

    //$placesAvailable
    public function getPlacesAvailable(): ?int
    {
        return $this->placesAvailable;
    }

    public function setPlacesAvailable(?int $placesAvailable): self
    {
        $this->placesAvailable = $placesAvailable;
        return $this;
    }

    //$price
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    //$description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }


}