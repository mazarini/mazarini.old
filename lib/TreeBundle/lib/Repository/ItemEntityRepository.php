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

namespace Mazarini\TreeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mazarini\ToolBundle\Repository\EntityRepository;
use Mazarini\TreeBundle\Entity\ItemEntityInterface;

/**
 * extends ServiceEntityRepository<EntityInterface>.
 *
 * @method ItemEntityInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemEntityRepository extends EntityRepository
{
}
