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

use App\Entity\ItemEntity;
use App\Repository\ItemEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Mazarini\TreeBundle\Factory\EntityTreeFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTreeFactoryTest extends KernelTestCase
{
    protected EntityTreeFactory $NodeFactory;
    protected static ItemEntityRepository $repository;

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
        $this->nodeFactory = new EntityTreeFactory(static::$repository);
    }

    public function testRoot(): void
    {
        $parentNode = $this->nodeFactory->getRootNode();
        $this->assertSame('parent', $parentNode->getItem()->getSlug());
    }

    public function testChilds(): void
    {
        foreach (['entity', 'child1', 'child2'] as $slug) {
            $node = $this->nodeFactory->getNode($slug);
            $parent = $this->nodeFactory->getNode($node->getParent()->getItem()->getKey());
            $this->assertSame($node, $parent[$slug]);
        }
    }

    public function testTree(): void
    {
        $root = $this->nodeFactory->getRootNode();
        $this->assertSame($this->nodeFactory->getNode('entity'), $root['entity']);
        $this->assertSame($this->nodeFactory->getNode('child1'), $root['entity']['child1']);
        $this->assertSame($this->nodeFactory->getNode('child2'), $root['entity']['child2']);
    }

    protected function tearDown(): void
    {
        while (1 === \count($object = static::$repository->findby([], ['id' => 'ASC'], 1, 0))) {
            $this->remove($object[0]);
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
