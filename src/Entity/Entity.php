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

namespace App\Entity;

use App\Repository\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Mazarini\ToolBundle\Entity\EntityAbstract;
use Mazarini\ToolBundle\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: EntityRepository::class)]
class Entity extends EntityAbstract implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): int
    {
        if (null === $this->id) {
            return 0;
        }

        return $this->id;
    }

    /**
     * Set the value of id.
     *
     * @return self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }
}
