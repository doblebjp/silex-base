<?php

namespace SilexMax;

use Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use SilexMax\Provider\TemplatingServiceProvider;
use SilexMax\Provider\OrmServiceProvider;
use SilexMax\Provider\FormServiceProvider;
use SilexMax\Application;

class Setup
{
    public static function createApplication()
    {
        return new Application();
    }

    public static function registerServices(Application $app)
    {
        $app->register(new SessionServiceProvider());
        $app->register(new MonologServiceProvider());
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new SwiftmailerServiceProvider());
        $app->register(new TemplatingServiceProvider());
        $app->register(new OrmServiceProvider());
        $app->register(new FormServiceProvider());
    }

    public static function loadConfig(Application $app, $path, array $replacements)
    {
        foreach (['/global.yml', '/local.yml'] as $configFile) {
            $configPath = $path . $configFile;
            if (file_exists($configPath)) {
                $app->register(new ConfigServiceProvider($configPath, $replacements));
            }
        }
    }

    public static function mountControllers(Application $app)
    {

    }
}
