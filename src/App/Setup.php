<?php

namespace App;

use SilexMax\Application;
use SilexMax\Setup as SilexMaxSetup;

class Setup extends SilexMaxSetup
{
    static public function mountControllers(Application $app)
    {
        $app->mount('/', new ControllerProvider());
    }
}
