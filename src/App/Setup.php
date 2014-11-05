<?php

namespace App;

use SilexBase\Application;
use SilexBase\Setup as SilexBaseSetup;

class Setup extends SilexBaseSetup
{
    static public function mountControllers(Application $app)
    {
        $app->mount('/', new ControllerProvider());
    }
}
