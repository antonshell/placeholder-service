<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Helper\PathHelper;
use Image;
use SapientPro\ImageComparator\ImageComparator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        self::assertEquals(200, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals(['status' => 'ok', 'service' => 'placeholder service'], $content);
    }

    /**
     * @dataProvider imageDataProvider
     */
    public function testImage(string $url, string $file): void
    {
        $expectedFilesDir = PathHelper::getBasePath() . '/resources/test_images';

        if (isset($_ENV['DOCKER_ENVIRONMENT']) || isset($_ENV['GA_ENVIRONMENT'])) {
            $expectedFilesDir = PathHelper::getBasePath() . '/resources/test_images_docker';
        }

        $client = static::createClient();

        $client->request('GET', $url);
        self::assertEquals(200, $client->getResponse()->getStatusCode());

        // save generated image to temp directory
        $tempImagePath = PathHelper::getBasePath() . '/temp/temp.png';
        file_put_contents($tempImagePath, $client->getInternalResponse()->getContent());

        $expectedFilePath = sprintf('%s/%s', $expectedFilesDir, $file);

        // compare with existing image
        $imageComparator = new ImageComparator();
        $similarity = $imageComparator->compare($expectedFilePath, $tempImagePath);
        self::assertEquals(100, $similarity);

        unlink($tempImagePath);
    }

    public function testImageUnsupportedFormat(): void
    {
        $client = static::createClient();
        $client->request('GET', '/img?format=svg');
        self::assertEquals(400, $client->getResponse()->getStatusCode());
        self::assertEquals([
            'status' => 'error',
            'message' => 'Unsupported image format requested: svg',
        ], json_decode($client->getInternalResponse()->getContent(), true));
    }

    public static function imageDataProvider(): array
    {
        return [
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
            [
                'url' => '/img?format=png', // png format
                'file' => 'img.png',
            ],
            [
                'url' => '/img?format=jpeg', // jpeg format
                'file' => 'img.jpeg',
            ],
            [
                'url' => '/img?format=gif', // gif format
                'file' => 'img.gif',
            ],
        ];
    }
}
