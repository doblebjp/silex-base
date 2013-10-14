<?php

namespace SilexMax\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use SilexAssetic\AsseticServiceProvider;
use Assetic\Filter\Yui\CssCompressorFilter;
use Assetic\Filter\Yui\JsCompressorFilter;
use Assetic\Filter\LessphpFilter;
use Assetic\Asset\AssetCache;
use Assetic\Asset\GlobAsset;
use Assetic\Asset\FileAsset;
use Assetic\Cache\FilesystemCache;

class TemplatingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new TwigServiceProvider(), [
            'twig.path' => $app['template_dir'],
            'twig.options' => [
                'cache' => $app['cache_dir'] . '/twig',
            ],
        ]);
        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new AsseticServiceProvider());

        $app['assetic.path_to_web'] = $app['web_dir'];
        $app['assetic.options'] = [
            'debug' => $app['debug'],
            'formulae_cache_dir' => $app['cache_dir'] . '/assetic',
            'auto_dump_assets' => $app['debug'],
        ];

        $app['assetic.filter_manager'] = $app->share($app->extend('assetic.filter_manager', function($fm, $app) {
            $fm->set('yui_css', new CssCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('yui_js', new JsCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('lessphp', new LessphpFilter());
            return $fm;
        }));

        $app['assetic.asset_manager'] = $app->share($app->extend('assetic.asset_manager', function($am, $app) {
            $fm = $app['assetic.filter_manager'];

            $am->set('bootstrap_css', new AssetCache(
                new FileAsset($app['twbs_dir'] . '/less/bootstrap.less', [$fm->get('lessphp')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('bootstrap_css')->setTargetPath('assets/css/bootstrap.css');

            $am->set('bootstrap_js', new AssetCache(
                new GlobAsset($app['twbs_dir'] . '/js/*.js'),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('bootstrap_js')->setTargetPath('assets/js/bootstrap.js');

            $am->set('custom_css', new AssetCache(
                new FileAsset($app['assets_dir'] . '/less/custom.less', [$fm->get('lessphp')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('custom_css')->setTargetPath('assets/css/custom.css');

            $am->set('custom_js', new AssetCache(
                new GlobAsset($app['assets_dir'] . '/js/*.js'),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('custom_js')->setTargetPath('assets/js/custom.js');

            return $am;
        }));

    }

    public function boot(Application $app)
    {

    }
}