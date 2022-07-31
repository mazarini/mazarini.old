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

use Mazarini\TreeBundle\Item\KeyItemAbstract;
use PHPUnit\Framework\TestCase;

class KeyItemTest extends TestCase
{
    public function testEqual(): void
    {
        $item = new KeyItem('A');
        $this->assertTrue($item->equal(new KeyItem('A')));
    }

    public function testNotEqual(): void
    {
        $item = new KeyItem('A');
        $this->assertFalse($item->equal(new KeyItem('B')));
    }
}

class KeyItem extends KeyItemAbstract
{
    private string $data = '';

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function getKey(): string
    {
        return $this->data;
    }
}
