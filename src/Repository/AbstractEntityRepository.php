<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractEntityRepository extends ServiceEntityRepository
{
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(object $entity, bool $flush = true): void
    {
        $em = $this->getEntityManager();

        $em->remove($entity);

        if ($flush) {
            $em->flush();
        }
    }

    public function save(object $entity, bool $flush = true): void
    {
        $em = $this->getEntityManager();

        $em->persist($entity);

        if ($flush) {
            $em->flush();
        }
    }
}
