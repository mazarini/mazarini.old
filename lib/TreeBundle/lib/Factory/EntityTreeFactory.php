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

namespace Mazarini\TreeBundle\Factory;

use Mazarini\TreeBundle\Entity\ItemEntityInterface;
use Mazarini\TreeBundle\Node\EntityNode as Node;
use Mazarini\TreeBundle\Repository\ItemEntityRepository;

/**
 * EntityTreeFactory.
 */
class EntityTreeFactory
{
    protected ItemEntityRepository $repository;

    /**
     * entities.
     *
     * @var array<int|string,Node>
     */
    protected array $nodes;

    public function __construct(ItemEntityRepository $repository = null)
    {
        if (null !== $repository) {
            $this->repository = $repository;
        }
    }

    /**
     * getNode.
     *
     * @param int|string           $identifier
     * @param ItemEntityRepository $repository
     *
     * @return Node
     */
    public function getNode(mixed $identifier, ItemEntityRepository $repository = null): ?Node
    {
        if (!isset($this->nodes)) {
            $this->setEntities($repository);
        }

        return (isset($this->nodes[$identifier])) ? $this->nodes[$identifier] : null;
    }

    public function getRootNode(ItemEntityRepository $repository = null): ?Node
    {
        return $this->getNode(0, $repository);
    }

    public function getEntity(int|string $identifier, ItemEntityRepository $repository = null): ?ItemEntityInterface
    {
        $node = $this->getNode($identifier, $repository);

        return (null === $node) ? null : $node->getItem();
    }

    public function getRootEntity(ItemEntityRepository $repository = null): ?ItemEntityInterface
    {
        return $this->getEntity(0, $repository);
    }

    protected function setEntities(ItemEntityRepository $repository = null): void
    {
        $this->nodes = [];
        if (null === $repository) {
            $repository = $this->repository;
        }
        $all = $repository->findAll();
        [$root] = $repository->findBy([], ['id' => 'ASC'], 1, 0);
        $this->nodes[0] = new Node($root);
        if (null !== $root) {
            $this->across($this->nodes[0]);
        }
    }

    protected function across(Node $parent): void
    {
        $this->nodes[$parent->getItem()->getId()] = $parent;
        $this->nodes[$parent->getItem()->getSlug()] = $parent;
        foreach ($parent->getItem()->getChilds() as $childEntity) {
            $childNode = new Node($childEntity);
            $parent[] = $childNode;
            $this->across($childNode);
        }
    }
}
