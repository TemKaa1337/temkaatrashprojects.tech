<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GithubRepo;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GithubRepo|null findOneByName(string $name)
 * @method GithubRepo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class GithubRepoRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GithubRepo::class);
    }
}
