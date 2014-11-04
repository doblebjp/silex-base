<?php

namespace SilexBase;

use Silex\Application as SilexApplication;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Application\MonologTrait;
use Silex\Application\FormTrait;
use Silex\Application\SecurityTrait;
use Silex\Route\SecurityTrait as RouteSecurityTrait;
use Silex\Application\SwiftmailerTrait;
use Silex\Application\TranslationTrait;

class Application extends SilexApplication
{
    use TwigTrait;
    use UrlGeneratorTrait;
    use MonologTrait;
    use FormTrait;
    use SecurityTrait;
    use RouteSecurityTrait;
    use SwiftmailerTrait;
    use TranslationTrait;
}
