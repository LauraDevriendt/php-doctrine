<?php
declare(strict_types=1);

namespace App\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
/**
 * @Entity()
 * @Table("students")
 */
class Student
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue *
     */
    private $id;

    /** @Column(type="string") * */
    private $firstName;

    /** @Column(type="string") * */
    private $lastName;

    /** @Column(type="string") * */
    private $email;

    /** @Embedded(class="Address") */
    private $address;

    /**
     * One teacher has many students. This is the inverse side.
     * @ManyToOne(targetEntity=Teacher::class)
     */
    private $teacher;

    /**
     * Student constructor.
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $address
     * @param $teacher
     */
    public function __construct(string $firstName, string $lastName,string $email,Address $address, Teacher $teacher)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->address = $address;
        $this->teacher = $teacher;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }


    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'address' => $this->getAddress()->toArray(),
            'teacher' =>$this->getTeacher()->getId()
        ];
    }
}