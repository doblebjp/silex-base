<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use SilexMax\Controller\TwigInterface;
use SilexMax\Controller\TwigTrait;

class TestController implements TwigInterface
{
    use TwigTrait;

    public function test(Application $app)
    {
        if (true !== $app['debug']) {
            return $app->abort(404);
        }

        return new Response($this->render('test.html.twig'));
    }
}
