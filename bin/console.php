<?php

// try finding local autoloader
$loader = @include __DIR__ . '/../vendor/autoload.php';
if ($loader instanceof Composer\Autoload\ClassLoader) {
    // local project exists
    $rootDir = realpath(__DIR__ . '/..');
} else {
    // try finding parent autoloader
    $loader = @include __DIR__ . '/../../../../vendor/autoload.php';
    if (!$loader instanceof Composer\Autoload\ClassLoader) {
        throw new Exception('Cannot locate autoloader');
    }
    $rootDir = realpath(__DIR__ . '/../../../..');
}

$loader->add('App', $rootDir . '/src');

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Knp\Provider\ConsoleServiceProvider;
use App\Setup;

$app = Setup::createApplication();
$app->register(new SilexMax\Provider\TemplatingServiceProvider());
$app->register(new SilexMax\Provider\OrmServiceProvider());
Setup::loadConfig($app, $rootDir . '/config', ['root_dir' => $rootDir]);

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
