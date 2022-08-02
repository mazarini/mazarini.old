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

namespace Mazarini\TreeBundle\Tests\Repository;

use App\Entity\ItemEntity;
use App\Repository\ItemEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemEntityRepositoryTest extends KernelTestCase
{
    protected static ItemEntityRepository $repository;
    protected int $id = 0;

    public static function setUpBeforeClass(): void
    {
    }

    protected function setUp(): void
    {
        static::setRepository();
        $this->tearDown();

        $parent = new ItemEntity();
        $parent->setSlug('parent');
        static::$repository->add($parent, true);
        $entity = new ItemEntity();
        $entity->setSlug('entity');
        static::$repository->add($entity, true);
        $child1 = new ItemEntity();
        $child1->setSlug('child1');
        $child2 = new ItemEntity();
        $child2->setSlug('child2');
        $parent->addChild($entity);
        $entity->addChild($child1);
        $entity->addChild($child2);
        static::$repository->add($child1);
        static::$repository->add($child2);
        static::$repository->flush();
    }

    public function testFindBySlug(): void
    {
        $entity = static::$repository->findOneBySlug('entity');
        $this->assertNotNull($entity);
        $this->assertSame('entity', $entity->getSlug());
        $this->assertSame('parent', $entity->getParent()->getSlug());
        $this->assertSame(2, $entity->getChilds()->count());
        $childs = [];
        foreach ($entity->getChilds() as $child) {
            $childs[$child->getslug()] = $child;
        }
        $this->assertTrue(isset($childs['child1']));
        $this->assertTrue(isset($childs['child2']));
    }

    protected function tearDown(): void
    {
        while (1 === \count($object = static::$repository->findby([], ['id' => 'ASC'], 0, 1))) {
            static::$repository->remove($object[0], true);
        }
    }

    protected function remove(ItemEntity $object): void
    {
        foreach ($object->getChilds() as $child) {
            $this->remove($child);
        }
        static::$repository->remove($object, true);
    }

    public static function setRepository(): void
    {
        $registry = static::getContainer()->get('doctrine');
        if (null !== $registry && is_a($registry, Registry::class)) {
            $repository = $registry->getRepository(ItemEntity::class);
            if (is_a($repository, ItemEntityRepository::class)) {
                static::$repository = $repository;
            }
        }
    }
}
