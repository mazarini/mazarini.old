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

use Mazarini\TreeBundle\Entity\ItemEntityInterface;

/**
 * @property ItemEntityInterface $item
 * @property EntityNode          $parent
 *
 * @method ItemEntityInterface getItem()
 */
class EntityNode extends Node
{
    /**
     * offsetSet.
     *
     * @param string|int|null $key
     * @param EntityNode      $value
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $value->setParent($this);
        if (null === $key) {
            $key = $value->getItem()->getKey();
        }
        parent::offsetSet($key, $value);
    }

    protected function verifyParentItem(): bool
    {
        $parentItem = (isset($this->parent)) ? $this->parent->getItem() : null;
        $itemParent = (isset($this->item)) ? $this->item->getParent() : null;
        if (null === $parentItem) {
            return null === $itemParent;
        }

        return $parentItem->equal($itemParent);
    }
}
