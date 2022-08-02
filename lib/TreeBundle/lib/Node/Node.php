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
 * Node.
 *
 * @extends \ArrayIterator<int|string,NodeInterface>
 */
class Node extends \ArrayIterator implements NodeInterface
{
    /**
     * parent.
     */
    protected NodeInterface $parent;

    /**
     * item.
     */
    protected ItemInterface $item;

    public function __construct(ItemInterface $item = null)
    {
        if (null !== $item) {
            $this->item = $item;
        }
        parent::__construct();
    }

    /**
     * offsetSet.
     *
     * @param string|int|null $key
     * @param NodeInterface   $value
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $value->setParent($this);
        if (null === $key) {
            $key = $value->getItem()->getKey();
        }
        parent::offsetSet($key, $value);
    }

    public function getRoot(): NodeInterface
    {
        if (isset($this->parent)) {
            return $this->parent->getRoot();
        }

        return $this;
    }

    /**
     * Get parent.
     */
    public function getCurrent(NodeInterface $root = null): ItemInterface
    {
        if (null === $root) {
            $root = $this->getRoot();
        }

        return $root->getItem();
    }

    public function isCurrent(ItemInterface $currentItem = null): bool
    {
        if (null === $currentItem) {
            $currentItem = $this->getCurrent($this->getRoot());
        }

        if ($this->item->equal($currentItem)) {
            return true;
        }
        foreach ($this as $child) {
            if ($child->isCurrent($currentItem)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get parent.
     */
    public function getParent(): NodeInterface
    {
        return $this->parent;
    }

    /**
     * Set parent.
     */
    public function setParent(NodeInterface $parent): NodeInterface
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get item.
     */
    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    /**
     * Set item.
     */
    public function setItem(ItemInterface $item): NodeInterface
    {
        $this->item = $item;

        return $this;
    }
}
