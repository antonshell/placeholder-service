<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Image;
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
        $configuration = [
            [
                'url' => '/img', // 300x300
                'file' => 'img.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?width=500', // 500x500
                'file' => 'img_width=500.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?height=400', // 400x400
                'file' => 'img_height=400.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?width=320&height=240', // 320x240
                'file' => 'img_width=320_height=240.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?text=Hello', // custom text
                'file' => 'img_text=Hello.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?width=800&text_size=40', // text size
                'file' => 'img_width=800_text_size=40.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?color_text=000', // text color
                'file' => 'img_color_text=000.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?color_bg=000', // background color
                'file' => 'img_color_bg=000.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?color_text=000000', // text color
                'file' => 'img_color_text=000000.png',
            ],
            [
                'url' => 'http://127.0.0.1:8000/img?color_bg=000000', // background color
                'file' => 'img_color_bg=000000.png',
            ],
        ];

        $expectedFilesDir = __DIR__ . '/../../resources/test_images';

        if (isset($_ENV['DOCKER_ENVIRONMENT']) || isset($_ENV['GA_ENVIRONMENT'])) {
            $expectedFilesDir = __DIR__ . '/../../resources/test_images_docker';
        }

        $client = static::createClient();
        foreach ($configuration as $row) {
            $client->request('GET', $row['url']);
            $this->assertEquals(200, $client->getResponse()->getStatusCode());

            // save generated image to temp directory
            $tempImagePath = __DIR__ . '/../../temp/temp.png';
            file_put_contents($tempImagePath, $client->getResponse()->getContent());

            $expectedFilePath = sprintf('%s/%s', $expectedFilesDir, $row['file']);

            // compare with existing image
            $expectedImage = Image::fromFile($expectedFilePath);
            $generatedImage = Image::fromFile($tempImagePath);
            $equal = $expectedImage->compare($generatedImage);

            $this->assertTrue($equal);

            unlink($tempImagePath);
        }
    }
}
