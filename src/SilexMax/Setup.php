<?php

namespace SilexMax;

use Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use SilexMax\Provider\TemplatingServiceProvider;
use SilexMax\Provider\OrmServiceProvider;
use SilexMax\Provider\FormServiceProvider;
use SilexMax\Application;

class Setup
{
    static public function createApplication()
    {
        return new Application();
    }

    static public function registerServices(Application $app)
    {
        $app->register(new SessionServiceProvider());
        $app->register(new MonologServiceProvider());
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new TemplatingServiceProvider());
        $app->register(new OrmServiceProvider());
        $app->register(new FormServiceProvider());
    }

    static public function loadConfig(Application $app, $path, array $replacements)
    {
        foreach (['/global.yml', '/local.yml'] as $configFile) {
            $configPath = $path . $configFile;
            if (file_exists($configPath)) {
                $app->register(new ConfigServiceProvider($configPath, $replacements));
            }
        }
    }

    static public function mountControllers(Application $app)
    {

    }
}
