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

namespace Mazarini\TreeBundle\Tests\Factory;

use App\Entity\Entity;
use App\Repository\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityRepositoryTest extends KernelTestCase
{
    protected static EntityRepository $repository;
    protected int $id = 0;

    public static function setUpBeforeClass(): void
    {
        static::setRepository();
    }

    protected function setUp(): void
    {
        $this->tearDown();

        $entity = new Entity();
        static::$repository->add($entity, true);
        $this->id = $entity->getId();
    }

    public function testFindById(): void
    {
        $entity = static::$repository->findOneById($this->id);
        $this->assertNotNull($entity);
        $this->assertSame($this->id, $entity->getId());
    }

    public function testRemove(): void
    {
        $entity = static::$repository->findOneById($this->id);
        $this->assertNotNull($entity);
        static::$repository->remove($entity, true);
        $entity = static::$repository->findOneById(1);
        $this->assertNull($entity);
    }

    protected function tearDown(): void
    {
        foreach (static::$repository->findAll() as $object) {
            static::$repository->remove($object, true);
        }
    }

    public static function setRepository(): void
    {
        $registry = static::getContainer()->get('doctrine');
        if (null !== $registry && is_a($registry, Registry::class)) {
            $repository = $registry->getRepository(Entity::class);
            if (is_a($repository, EntityRepository::class)) {
                static::$repository = $repository;
            }
        }
    }
}
