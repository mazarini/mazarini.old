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

namespace Mazarini\TreeBundle\Tests\Factory;

use Mazarini\TreeBundle\Factory\FileFactory;
use Mazarini\TreeBundle\Factory\FolderFactory;
use Mazarini\TreeBundle\Node\Node;
use PHPUnit\Framework\TestCase;

class FolderFactoryTest extends TestCase
{
    protected Node $folder;

    public static function setUpBeforeClass(): void
    {
        $root = static::getRoot();
        static::rmTmp($root);
        static::mkTmp($root.'/1/1/1/1.ext');
        static::mkTmp($root.'/1/1/1/2.ext');
        static::mkTmp($root.'/1/1/2/1.ext');
        static::mkTmp($root.'/1/1/2/2.ext');
        static::mkTmp($root.'/1/2/1/1.ext');
        static::mkTmp($root.'/2/1/1/1.ext');
    }

    protected function setUp(): void
    {
        $folderFactory = new FolderFactory(new FileFactory());
        $this->folder = $folderFactory->getFolder(static::getRoot());
    }

    public function testFolderFactory(): void
    {
        $root = static::getRoot();

        $firstKey = $this->folder->key();
        $firstValue = $this->folder->current();
        $this->assertSame($root.'/1', $firstKey);
        $this->assertSame($root.'/1', $firstValue->getItem()->path());

        $firstKey = $firstValue->key();
        $firstValue = $firstValue->current();
        $this->assertSame($root.'/1/1', $firstKey);
        $this->assertSame($root.'/1/1', $firstValue->getItem()->path());

        $firstKey = $firstValue->key();
        $firstValue = $firstValue->current();
        $this->assertSame($root.'/1/1/1', $firstKey);
        $this->assertSame($root.'/1/1/1', $firstValue->getItem()->path());

        $firstKey = $firstValue->key();
        $firstValue = $firstValue->current();
        $this->assertSame($root.'/1/1/1/1.ext', $firstKey);
        $this->assertSame($root.'/1/1/1/1.ext', $firstValue->getItem()->path());
    }

    public static function tearDownAfterClass(): void
    {
        static::rmTmp(static::getRoot());
    }

    protected static function getRoot(): string
    {
        return \dirname(__DIR__, 2).'/var/tmp';
    }

    protected static function mkTmp(string $file, bool $isDir = false): bool
    {
        if (file_exists($file)) {
            return true;
        }

        if (!file_exists(\dirname($file))) {
            static::mkTmp(\dirname($file), true);
        }
        if ($isDir) {
            return mkdir($file);
        } else {
            return touch($file);
        }
    }

    protected static function rmTmp(string $dir): bool
    {
        if (is_file($dir)) {
            return unlink($dir);
        }
        $files = scandir($dir);
        if (false === $files) {
            $files = [];
        } else {
            $files = array_diff($files, ['.', '..']);
        }
        foreach ($files as $file) {
            static::rmTmp($dir.'/'.$file);
        }

        if (is_dir($dir)) {
            return rmdir($dir);
        }

        return false;
    }
}
