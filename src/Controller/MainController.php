<?php

namespace App\Controller;

use App\Service\PlaceholderGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @var PlaceholderGenerator
     */
    private $placeholderGenerator;

    public function __construct(
        PlaceholderGenerator $placeholderGenerator
    )
    {
        $this->placeholderGenerator = $placeholderGenerator;
    }

    public function index(Request $request): Response
    {
        return new JsonResponse([
            'status' => 'ok',
            'service' => 'placeholder service',
        ]);
    }

    public function image(Request $request): void
    {
        $width = $request->get('width');
        $height = $request->get('height');

        if(!$width && !$height) {
            $width = 150;
            $height = 150;
        }

        if($width && !$height) {
            $height = $width;
        }

        if($height && !$width) {
            $width = $height;
        }

        $text = $request->get('text');
        $colorText = $request->get('color_text', PlaceholderGenerator::COLOR_WHITE);
        $colorBg = $request->get('color_bg', PlaceholderGenerator::COLOR_GREY);
        $textSize = $request->get('text_size', PlaceholderGenerator::DEFAULT_TEXT_SIZE);;
        $this->placeholderGenerator->generate((int) $width, (int) $height, $text, $textSize, $colorText, $colorBg);
    }
}
