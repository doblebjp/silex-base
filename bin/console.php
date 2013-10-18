<?php

$app = require __DIR__ . '/../src/app.php';

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Knp\Provider\ConsoleServiceProvider;

$app->register(new ConsoleServiceProvider(), [
    'console.name'              => 'SilexMax Console',
    'console.version'           => '1.0',
    /***/ 'console.project_directory' => getcwd(),
    ///// 'console.project_directory' => __DIR__,
]);

$console = $app['console'];
$console->setCatchExceptions(true);

$console->setHelperSet(new HelperSet([
    new TableHelper(),
    new DialogHelper(),
    new FormatterHelper(),
]));

$console->addCommands([
    new SilexMax\Console\CreateProjectCommand(),
    new SilexMax\Console\FileDirPermissionCommand(),
    new SilexMax\Console\AssetDumpCommand(),
    new SilexMax\Console\LoadFixturesCommand(),
]);

$console->run();
