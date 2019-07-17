<?php

$finder = \PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ;

return PhpCsFixer\Config::create()
    ->setFinder($finder)
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'declare_strict_types' => true,
    ])
    ->setLineEnding("\n")
;
