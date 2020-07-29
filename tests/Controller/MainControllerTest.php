<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(['status' => 'ok', 'service' => 'placeholder service'], $content);
    }

    public function testImage()
    {
        $client = static::createClient();
        $client->request('GET', '/img');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}