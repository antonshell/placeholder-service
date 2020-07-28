<?php

namespace App\Controller;

use App\Service\PlaceholderGenerator;
use App\Service\ResolutionService;
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

    /**
     * @var ResolutionService
     */
    private $resolutionService;

    public function __construct(
        PlaceholderGenerator $placeholderGenerator,
        ResolutionService $resolutionService
    )
    {
        $this->placeholderGenerator = $placeholderGenerator;
        $this->resolutionService = $resolutionService;
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
        $resolution = $this->resolutionService->createFromRequest($request);
        $text = $request->get('text');
        $colorText = $request->get('color_text', PlaceholderGenerator::COLOR_WHITE);
        $colorBg = $request->get('color_bg', PlaceholderGenerator::COLOR_GREY);
        $textSize = $request->get('text_size', PlaceholderGenerator::DEFAULT_TEXT_SIZE);;
        $this->placeholderGenerator->generate((int) $resolution->getWidth(), (int) $resolution->getHeight(), $text, $textSize, $colorText, $colorBg);
    }
}
