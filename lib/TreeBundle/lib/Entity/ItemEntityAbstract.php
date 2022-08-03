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

namespace Mazarini\TreeBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Mazarini\ToolBundle\Entity\Entity as Base;
use Mazarini\TreeBundle\Item\ItemInterface;

abstract class ItemEntityAbstract extends Base implements ItemEntityInterface
{
    abstract public function getParent(): ItemEntityInterface;

    /**
     * getChilds.
     *
     * @return Collection <int, ItemEntityInterface>
     */
    abstract public function getChilds(): Collection;

    public function getKey(): string
    {
        return $this->getSlug();
    }

    public function getSlug(): string
    {
        return sprintf('%s', $this->getId());
    }

    public function equal(?ItemInterface $item): bool
    {
        return $this === $item;
    }

    public function __toString(): string
    {
        return sprintf('%s(%s)', $this->getSlug(), $this->getId());
    }
}
