<?php
namespace EHDev\FestivalBasicsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FestivalRepository extends EntityRepository
{
    public function findActiveFestivals()
    {
        return $this->findBy(['isActive' => true]);
    }
}
