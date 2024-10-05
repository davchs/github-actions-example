<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor');

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => true,
    'no_unused_imports' => true,
    'yoda_style' => false,
    'phpdoc_order' => true,
    'phpdoc_summary' => false,
    'phpdoc_no_empty_return' => false,
    'single_line_throw' => false,
])
    ->setCacheFile(__DIR__.'/.cache/php-cs-fixer.json')
    ->setFinder($finder);
