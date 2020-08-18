<?php

declare(strict_types=1);

namespace App\Entity;

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Address
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $zipcode;
    /**
     * Address constructor.
     * @param $street
     * @param $streetNumber
     * @param $city
     * @param $zipcode
     */
    public function __construct(string $street, int $streetNumber, string $city, int $zipcode)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->zipcode = $zipcode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getZipcode(): int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode)
    {
        $this->zipcode = $zipcode;
    }

    public function toArray()
    {
        return [
            'street' => $this->getStreet(),
            'streetNumber' => $this->getStreetNumber(),
            'city' => $this->getCity(),
            'zipcode' => $this->getZipcode()
        ];
    }
}