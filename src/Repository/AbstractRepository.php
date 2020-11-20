<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\UnitOfWork;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function save(object $entity): bool
    {
        $entityManager = $this->getEntityManager();

        $unitOfWork = $entityManager->getUnitOfWork();

        $unitOfWork->computeChangeSets();

        if ($unitOfWork->getEntityState($entity) === UnitOfWork::STATE_NEW) {
            $entityManager->persist($entity);
        }

        $changeSet = $unitOfWork->getEntityChangeSet($entity);
        $collectionUpdates = $unitOfWork->getScheduledCollectionUpdates();

        $entityManager->flush();

        return !(empty($changeSet) && empty($collectionUpdates));
    }

    public function delete(object $entity): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($entity);
        $entityManager->flush($entity);
    }
}
