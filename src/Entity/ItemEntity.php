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

use App\Repository\ItemEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Mazarini\TreeBundle\Entity\ItemEntityAbstract;
use Mazarini\TreeBundle\Entity\ItemEntityInterface;

#[ORM\Entity(repositoryClass: ItemEntityRepository::class)]
class ItemEntity extends ItemEntityAbstract implements ItemEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = 0;

    #[ORM\Column(length: 255)]
    private string $slug = '';
    /**
     * @var self $parent
     */
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childs')]
    private ItemEntityInterface $parent;

    /**
     * @var Collection<int, ItemEntityInterface> $childs
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $childs;

    public function __construct()
    {
        $this->childs = new ArrayCollection();
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * getParent.
     *
     * @return self
     */
    public function getParent(): ItemEntityInterface
    {
        return $this->parent;
    }

    public function setParent(self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, ItemEntityInterface>
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs->add($child);
            $child->setParent($this);
        }

        return $this;
    }
}
