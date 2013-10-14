<?php

namespace SilexMax;

use Silex\Application as SilexApplication;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Application\MonologTrait;
use Silex\Application\FormTrait;

class Application extends SilexApplication
{
    use TwigTrait;
    use UrlGeneratorTrait;
    use MonologTrait;
    use FormTrait;
}
