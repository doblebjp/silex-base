<?php

$app = require __DIR__ . '/../src/app.php';

use Symfony\Component\Console\Application as ConsoleApp;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\FormatterHelper;

use SilexMax\Console\ContainerHelper;

$console = new ConsoleApp('SilexMax Console', '1.0');
$console->setCatchExceptions(true);

$console->setHelperSet(new HelperSet([
    new ContainerHelper($app),
    new TableHelper(),
    new DialogHelper(),
    new FormatterHelper(),
]));

$console->addCommands([
    new SilexMax\Console\AssetDumpCommand(),
]);

$console->run();
