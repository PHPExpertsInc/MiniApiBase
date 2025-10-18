#!/bin/env php
<?php declare(strict_types=1);

/**
 * This file is part of MiniApiBase, a PHP Experts, Inc., Project.
 *
 * Copyright © 2024-2025 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *   GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *   https://www.phpexperts.pro/
 *   https://github.com/PHPExpertsInc/MiniApiBase
 *
 * This file is licensed under the MIT License.
 */

use Minicli\Command\CommandCall;

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/.framework/boot.php';
require __DIR__ . '/.framework/boot-cli.php';


$app->registerCommand('greet', function (CommandCall $cli) use ($app, $p) {
    $args = $cli->getRawArgs();
    $name = $args[2] ?? 'World';
    echo $p->red("Hello, ")->bold()->lightCyan($name)->text("!\n");
}, '<name>', 'Emits a salutation.');

// Register new commands here...
$app->registerCommand('new', function (CommandCall $cli) {
}, '', 'new');

$app->runCommand($argv);
