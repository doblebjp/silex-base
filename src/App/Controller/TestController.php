<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function test(Application $app)
    {
        if (true !== $app['debug']) {
            return $app->abort(404);
        }

        return $app->render('test.html.twig');
    }
}
