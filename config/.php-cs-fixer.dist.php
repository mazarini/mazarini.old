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

 $projectRoot = dirname(__DIR__);
 if (!file_exists($projectRoot.'/src')) {
     echo '"',$projectRoot,'/src" don\'t exist!';
     exit(1);
 }

 $fileHeaderComment = <<<COMMENT
 This file is part of mazarini/mazarini.

 mazarini/mazarini is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 mazarini/mazarini is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 for more details.

 You should have received a copy of the GNU General Public License along
 with mazarini/mazarini. If not, see <https://www.gnu.org/licenses/>.
 COMMENT;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP71Migration' => true,
        '@PHPUnit75Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'protected_to_private' => false,
        'native_constant_invocation' => ['strict' => false],
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => false],
        'header_comment' => ['header' => $fileHeaderComment],
        'modernize_strpos' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in($projectRoot.'/src')
            ->in($projectRoot.'/lib')
            ->append([__FILE__])
            ->notPath('#/Fixtures/#')
            ->notPath('#/Resources/#')
            ->exclude([
            ])
            ->notPath('config/bundles.php')
    )
    ->setCacheFile($projectRoot.'/var/.php-cs-fixer.cache')
;
