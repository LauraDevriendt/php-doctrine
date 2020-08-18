<?php

namespace App\Repository;

use App\Entity\Address;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

// weet nu dat deze klas meer entities gaat managen
class TeacherRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        // weet alle linken tussen de klassen zijn en weet hoe je zaken kunt laden
        ManagerRegistry $registry,
        // manager van u database
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Teacher::class);
        $this->manager = $manager;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }




}
