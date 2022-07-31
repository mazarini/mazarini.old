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

namespace Mazarini\TreeBundle\Item;

class File extends KeyItemAbstract
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getKey(): int|string
    {
        return $this->path;
    }

    public function filename(): string
    {
        $pathinfo = $this->pathinfo();

        return $pathinfo['filename'];
    }

    /**
     * dirname.
     *
     * @param int<1, max> $level
     */
    public function dirname(int $level = 1): string
    {
        return \dirname($this->path, $level);
    }

    public function basename(): string
    {
        return basename($this->path);
    }

    public function extension(): string
    {
        $pathinfo = $this->pathinfo();
        if (isset($pathinfo['extension'])) {
            return $pathinfo['extension'];
        }

        return '';
    }

    /**
     * pathinfo.
     *
     * @return array<string,string>
     */
    protected function pathinfo(): array
    {
        $array = pathinfo($this->path);
        if (!\is_array($array)) {
            throw new \LogicException('pathinfo must return an array');
        }

        return $array;
    }
}
