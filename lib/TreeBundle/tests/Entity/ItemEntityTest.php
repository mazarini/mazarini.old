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

namespace Mazarini\TreeBundle\Tests\Entity;

use App\Entity\ItemEntity;
use PHPUnit\Framework\TestCase;

class ItemEntityTest extends TestCase
{
    private ItemEntity $parent;
    private ItemEntity $entity;
    private ItemEntity $child1;
    private ItemEntity $child2;

    protected function setUp(): void
    {
        $this->parent = new ItemEntity();
        $this->parent->setId(1)
        ->setSlug('parent');
        $this->entity = new ItemEntity();
        $this->entity->setId(2)
        ->setSlug('entity');
        $this->child1 = new ItemEntity();
        $this->child1->setId(3)
        ->setSlug('child1');
        $this->child2 = new ItemEntity();
        $this->child2->setId(4)
        ->setSlug('child2');
        $this->parent->addChild($this->entity);
        $this->entity->addChild($this->child1);
        $this->entity->addChild($this->child2);
    }

    public function testEntity(): void
    {
        $this->assertSame(2, $this->entity->getid());
        $this->assertSame('entity', $this->entity->getslug());
    }

    public function testParentException()
    {
        $this->expectException(\Error::class);
        $this->parent->getParent();
    }

    public function testParent(): void
    {
        $this->assertNotNull($this->entity->getParent());
        $this->assertSame($this->parent, $this->entity->getParent());
        $this->assertSame($this->entity, $this->child1->getParent());
        $this->assertSame($this->entity, $this->child2->getParent());
    }

    public function testChilds(): void
    {
        $this->assertSame(0, $this->child1->getChilds()->count());
        $this->assertSame(2, $this->entity->getChilds()->count());
        $this->assertSame($this->child1, $this->entity->getChilds()[0]);
        $this->assertSame($this->child2, $this->entity->getChilds()[1]);
    }
}
