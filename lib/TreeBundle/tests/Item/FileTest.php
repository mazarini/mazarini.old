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

namespace Mazarini\TreeBundle\Tests\Item;

use Mazarini\TreeBundle\Item\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @dataProvider provideFileData
     */
    public function testFile($path, $dirname, $basename, $filename, $extension): void
    {
        $file = new File($path);
        $this->assertSame($dirname, $file->dirname());
        $this->assertSame($basename, $file->basename());
        $this->assertSame($filename, $file->filename());
        $this->assertSame($extension, $file->extension());
    }

    public function provideFileData()
    {
        return [
        ['dirname/filename.extension', 'dirname', 'filename.extension', 'filename', 'extension'],
        ['dirname/filename', 'dirname', 'filename', 'filename', ''],
        ['dirname/.extension', 'dirname', '.extension', '', 'extension'],
        ['filename.extension', '.', 'filename.extension', 'filename', 'extension'],
        ['/filename.extension', '/', 'filename.extension', 'filename', 'extension'],
        ['dirname/.extension', 'dirname', '.extension', '', 'extension'],
    ];
    }
}
