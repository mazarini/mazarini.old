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

namespace Mazarini\TreeBundle\Node;

use Mazarini\TreeBundle\Item\ItemInterface;

/**
 * NodeInterface.
 *
 * @extends \SeekableIterator<int|string,NodeInterface>
 * @extends \ArrayAccess<int|string,NodeInterface>
 */
interface NodeInterface extends \SeekableIterator, \ArrayAccess, \Serializable, \Countable
{
    /**
     * offsetSet.
     *
     * @param string        $key
     * @param ItemInterface $value
     */
    public function offsetSet(mixed $key, mixed $value): void;

    public function getRoot(): self;

    public function getCurrent(?self $root): ItemInterface;

    public function isCurrent(?ItemInterface $currentItem): bool;

    public function getParent(): self;

    public function setParent(self $parent): self;

    public function getItem(): ItemInterface;

    public function setItem(ItemInterface $item): self;
}
