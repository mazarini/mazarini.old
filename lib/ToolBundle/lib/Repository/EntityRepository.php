<?php

/*
 * This file is part of mazarini/mazarini.
 *
 * mazarini/mazarini is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/mazarini is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/mazarini. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Mazarini\ToolBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mazarini\ToolBundle\Entity\EntityInterface;

/**
 * @extends ServiceEntityRepository<EntityInterface>
 */
class EntityRepository extends ServiceEntityRepository
{
    public function add(EntityInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->flush($flush);
    }

    public function remove(EntityInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->flush($flush);
    }

    public function flush(bool $flush = true): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
