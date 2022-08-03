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

use Mazarini\TreeBundle\Node\Node;

class FolderFactory
{
    protected FileFactory $fileFactory;

    public function __construct(FileFactory $fileFactory = null)
    {
        if (null !== $fileFactory) {
            $this->fileFactory = $fileFactory;
        }
    }

    public function getFolder(string $rootPath, FileFactory $fileFactory = null): Node
    {
        $node = new Node();
        if (null === $fileFactory) {
            $fileFactory = $this->fileFactory;
        }
        $this->acrossFolder($node, $rootPath, $fileFactory);

        return $node;
    }

    protected function acrossFolder(Node $node, string $rootPath, FileFactory $fileFactory): Node
    {
        $paths = scandir($rootPath);
        if (false === $paths) {
            $paths = [];
        }
        foreach ($paths as $item) {
            $path = $rootPath.'/'.$item;
            switch (true) {
                case \in_array($item, ['.', '..']):
                    break;
                 case is_file($path):
                    $node[] = new Node($fileFactory->getFile($path));
                    break;
                 case is_dir($path):
                    $node[] = $this->acrossFolder(new Node($fileFactory->getFile($path)), $path, $fileFactory);
                    break;
            }
        }

        return $node;
    }
}
