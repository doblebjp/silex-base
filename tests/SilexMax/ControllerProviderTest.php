<?php

use SilexMax\Tests\WebTestCase;
use SilexMax\ControllerProvider;

class ControllerProviderTest extends WebTestCase
{
    public function createApplication()
    {
        $app = parent::createApplication();
        $app->mount('/', new ControllerProvider());

        return $app;
    }

    public function testLoadingHomepageIsOk()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }
}
