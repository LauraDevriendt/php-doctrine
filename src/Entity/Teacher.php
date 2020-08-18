<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Embedded(class="Address")
     */
    private $address;


    /**
     * Teacher constructor.
     * @param $name
     * @param $email
     * @param $address
     */
    public function __construct(string $name, string $email, Address $address)
    {
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }



    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address){
        $this->address = $address;

    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'Name' => $this->getName(),
            'email' => $this->getEmail(),
            'address' => $this->getAddress()->toArray()
        ];
    }
}
