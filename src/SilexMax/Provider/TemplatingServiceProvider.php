<?php

namespace SilexMax\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use SilexAssetic\AsseticServiceProvider;
use Assetic\Filter\Yui\CssCompressorFilter;
use Assetic\Filter\Yui\JsCompressorFilter;
use Assetic\Filter\LessFilter;
use Assetic\Filter\JpegoptimFilter;
use Assetic\Filter\OptiPngFilter;
use Assetic\Asset\AssetCache;
use Assetic\Asset\GlobAsset;
use Assetic\Asset\FileAsset;
use Assetic\Asset\AssetCollection;
use Assetic\Cache\FilesystemCache;

class TemplatingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new TwigServiceProvider());

        $app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
            $twig->addFilter(new \Twig_SimpleFilter('grid', ['SilexMax\Twig\GridFilter', 'getClass']));

            return $twig;
        }));

        $app['twig.loader.filesystem'] = $app->share($app->extend('twig.loader.filesystem', function ($loader, $app) {
            $loader->addPath(__DIR__ . '/../../../views/common', 'SilexMax');

            return $loader;
        }));

        $app->register(new TranslationServiceProvider());
        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new AsseticServiceProvider());

        $app['assetic.filter_manager'] = $app->share($app->extend('assetic.filter_manager', function($fm, $app) {
            $fm->set('yui_css', new CssCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('yui_js', new JsCompressorFilter('/usr/share/yui-compressor/yui-compressor.jar'));
            $fm->set('lessc', new LessFilter($app['node.bin'], $app['node.paths']));
            $fm->set('jpegoptim', new JpegoptimFilter());
            $fm->set('optipng', new OptiPngFilter());

            return $fm;
        }));

        $app['assetic.asset_manager'] = $app->share($app->extend('assetic.asset_manager', function($am, $app) {
            $fm = $app['assetic.filter_manager'];

            $fm->get('lessc')->addLoadPath(realpath($app['twbs_dir'] . '/less'));

            $am->set('styles', new AssetCache(
                new AssetCollection([
                    new FileAsset($app['twbs_dir'] . '/less/bootstrap.less'),
                    new GlobAsset($app['assets_dir'] . '/less/*.less'),
                ], [$fm->get('lessc')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('styles')->setTargetPath('assets/css/styles.css');

            $am->set('scripts', new AssetCache(
                new AssetCollection([
                    new FileAsset($app['twbs_dir'] . '/js/affix.js'),
                    new FileAsset($app['twbs_dir'] . '/js/alert.js'),
                    new FileAsset($app['twbs_dir'] . '/js/button.js'),
                    new FileAsset($app['twbs_dir'] . '/js/carousel.js'),
                    new FileAsset($app['twbs_dir'] . '/js/collapse.js'),
                    new FileAsset($app['twbs_dir'] . '/js/dropdown.js'),
                    new FileAsset($app['twbs_dir'] . '/js/modal.js'),
                    new FileAsset($app['twbs_dir'] . '/js/scrollspy.js'),
                    new FileAsset($app['twbs_dir'] . '/js/tab.js'),
                    new FileAsset($app['twbs_dir'] . '/js/tooltip.js'),
                    new FileAsset($app['twbs_dir'] . '/js/popover.js'),
                    new FileAsset($app['twbs_dir'] . '/js/transition.js'),
                    new GlobAsset($app['assets_dir'] . '/js/*.js'),
                ]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('scripts')->setTargetPath('assets/js/scripts.js');

            /*
            $am->set('custom_css', new AssetCache(
                new FileAsset($app['assets_dir'] . '/less/custom.less', [$fm->get('lessc')]),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('custom_css')->setTargetPath('assets/css/custom.css');

            $am->set('custom_js', new AssetCache(
                new GlobAsset($app['assets_dir'] . '/js/*.js'),
                new FilesystemCache($app['cache_dir'] . '/assetic')
            ));
            $am->get('custom_js')->setTargetPath('assets/js/custom.js');
            */

            // jpeg
            $jpegs = glob($app['assets_dir'] . '/img/*.jpg');
            foreach ($jpegs as $file) {
                $name = basename($file);
                $assetName = str_replace('.', '_', "img_$name");
                $am->set($assetName, new AssetCache(
                    new FileAsset($file, [$fm->get('jpegoptim')]),
                    new FilesystemCache($app['cache_dir'] . '/assetic')
                ));
                $am->get($assetName)->setTargetPath("assets/img/$name");
            }

            // png
            $pngs = glob($app['assets_dir'] . '/img/*.png');
            foreach ($pngs as $file) {
                $name = basename($file);
                $assetName = str_replace('.', '_', "img_$name");
                $am->set($assetName, new AssetCache(
                    new FileAsset($file, [$fm->get('optipng')]),
                    new FilesystemCache($app['cache_dir'] . '/assetic')
                ));
                $am->get($assetName)->setTargetPath("assets/img/$name");
            }

            return $am;
        }));

    }

    public function boot(Application $app)
    {

    }
}
