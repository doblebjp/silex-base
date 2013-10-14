<?php

use App\Tests\WebTestCase;
use App\ControllerProvider;

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
