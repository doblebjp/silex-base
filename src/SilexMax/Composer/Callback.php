<?php

namespace SilexMax\Composer;

use Composer\Script\Event;

class Callback
{
    public static function postInstall(Event $event)
    {
        // data dir
        $dataDir = realpath(__DIR__ . '/../../../data');

        // cache
        chmod($dataDir . '/cache', 0777);

        // log
        chmod($dataDir . '/log', 0777);

        // sqlite
        chmod($dataDir . '/sqlite', 0777);
        $dbFile = $dataDir . '/sqlite/app.db';
        touch($dbFile);
        chmod($dbFile, 0666);

        // assets
        $assetsDir = realpath(__DIR__ . '/../../../web/assets');
        chmod($assetsDir, 0777);
    }
}
