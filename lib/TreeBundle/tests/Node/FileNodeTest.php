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

namespace Mazarini\TreeBundle\Tests\Item;

use Mazarini\TreeBundle\Item\File;
use Mazarini\TreeBundle\Node\Node;
use PHPUnit\Framework\TestCase;

class FileNodeTest extends TestCase
{
    private Node $root;

    protected function setUp(): void
    {
        $this->root = new Node();
        $this->root[] = new Node(new File('1'));
        $this->root['1'][] = new Node(new File('11'));
        $this->root['1'][] = new Node(new File('12'));
        $this->root['1'][] = new Node(new File('13'));
        $this->root['1']['13'][] = new Node(new File('131'));
        $this->root['1']['13'][] = new Node(new File('132'));
        $this->root['1']['13']['132'][] = new Node(new File('1321'));
        $this->root['1']['13'][] = new Node(new File('133'));
        $this->root[] = new Node(new File('2'));
        $this->root['2'][] = new Node(new File('21'));
        $this->root['2'][] = new Node(new File('22'));
        $this->root[] = new Node(new File('3'));
        $this->root['2'][] = new Node(new File('31'));
    }

    public function testParent(): void
    {
        $this->assertSame($this->root['1'], $this->root['1']['13']->getParent());
        $this->assertSame($this->root['1']['13'], $this->root['1']['13']['132']->getParent());
        $this->assertSame($this->root['1']['13']['132'], $this->root['1']['13']['132']['1321']->getParent());
    }

    public function testRoot(): void
    {
        $this->assertSame($this->root, $this->root['1']['13']->getRoot());
        $this->assertSame($this->root, $this->root['1']['13']['132']->getRoot());
        $this->assertSame($this->root, $this->root['1']['13']['132']['1321']->getRoot());
    }

    public function testItem(): void
    {
        $this->root->setItem($item = new File('item'));
        $this->assertSame($item, $this->root->getItem());
        $node = new Node($item);
        $this->assertSame($item, $node->getItem());
    }

    public function testGetCurrent(): void
    {
        $current = $this->root['1']['13']['132']['1321']->getItem();
        $this->root->setItem($current);
        $this->assertSame($current, $this->root->getCurrent());
        $this->assertSame($current, $this->root['2']->getCurrent());
        $this->assertSame($current, $this->root['1']['13']->getCurrent());
        $this->assertSame($current, $this->root['1']['13']['132']->getCurrent());
        $this->assertSame($current, $this->root['1']['13']['132']['1321']->getCurrent());
    }

    public function testIsCurrent(): void
    {
        $current = $this->root['1']['13']['132']['1321']->getItem();
        $this->root->setItem($current);
        $this->assertTrue($this->root['1']['13']['132']['1321']->isCurrent());
        $this->assertTrue($this->root['1']['13']['132']->isCurrent());
        $this->assertTrue($this->root['1']['13']->isCurrent());
        $this->assertTrue($this->root['1']->isCurrent());
        $this->assertTrue($this->root->isCurrent());
        $this->assertFalse($this->root['1']['13']['131']->isCurrent());
        $this->assertFalse($this->root['1']['12']->isCurrent());
    }
}
