<?php

// try finding local autoloader
$loader = @include __DIR__ . '/../vendor/autoload.php';
$rootDir = realpath(__DIR__ . '/..');

if (!$loader instanceof Composer\Autoload\ClassLoader) {
    // try finding parent autoloader
    $loader = @include __DIR__ . '/../../../../vendor/autoload.php';
    if (!$loader instanceof Composer\Autoload\ClassLoader) {
        throw new Exception('Cannot locate autoloader');
    }

    $rootDir = realpath(__DIR__ . '/../../../..');
}

use Knp\Provider\ConsoleServiceProvider;
use SilexBase\Setup;

$app = Setup::createApplication();
$app->register(new SilexBase\Provider\TemplatingServiceProvider());
$app->register(new SilexBase\Provider\OrmServiceProvider());
Setup::loadConfig($app, $rootDir . '/config', ['root_dir' => $rootDir]);

$app->register(new ConsoleServiceProvider(), [
    'console.name'              => 'App Console',
    'console.version'           => '1.0',
    'console.project_directory' => $rootDir,
]);

$console = $app['console'];
$console->setCatchExceptions(true);

$console->addCommands([
    new SilexBase\Console\BoilerplateCommand(),
    new SilexBase\Console\CompileAssetsCommand(),
    new SilexBase\Console\LoadFixturesCommand(),
]);

$console->run();
