<?php
declare(strict_types=1);

use Fyre\TestSuite\PhpCsFixer\Config;

$config = new Config();

$config->setUnsupportedPhpVersionAllowed(true);
$config->getFinder()
    ->in(__DIR__)
    ->exclude(['tmp']);

return $config;
