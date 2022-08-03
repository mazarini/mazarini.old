<?php

$projectRoot = dirname(__DIR__, 2);

if (!file_exists($projectRoot.'/src')) {
    echo '"',$projectRoot,'/src" don\'t exist!',"\n";
    echo 'Verify "$projectRoot" in config/phpcs/file.php',"\n";
    echo exit(1);
}

$fixer = (new PhpCsFixer\Config())
    ->setRules([
        '@PHP81Migration' => true,
        '@PSR12' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'protected_to_private' => false,
        'native_constant_invocation' => ['strict' => false],
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => false],
        'header_comment' => (isset($fileHeaderComment)) ? ['header' => $fileHeaderComment] : [],
        'modernize_strpos' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        (new PhpCsFixer\Finder())
        ->in($projectRoot.'/lib')
        ->in($projectRoot.'/src')
        ->in($projectRoot.'/tests')
        ->notPath('#/Fixtures/#')
        ->notPath('#/Resources/#')
        ->exclude([
            $projectRoot.'/config/bundles.php',
            $projectRoot.'/tests/bootstrap.php',
            $projectRoot.'/config/phpcs/file.php',
            $projectRoot.'/config/phpcs/global.php',
            ])
        ->notPath($projectRoot.'/config/bundles.php')
        ->notPath($projectRoot.'/tests/bootstrap.php')
        ->notPath($projectRoot.'/config/phpcs/file.php')
        ->notPath($projectRoot.'/config/phpcs/global.php')
    )
    ->setCacheFile($projectRoot.'/var/.php-cs-fixer.cache')
;

return $fixer;
