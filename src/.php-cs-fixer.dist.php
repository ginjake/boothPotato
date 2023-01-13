<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    // チェックするディレクトリの指定
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database/seeders',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
    ])
    ->setFinder($finder);
