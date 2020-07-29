<?php

namespace App\Controller;

use App\Request\ImageRequest;
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

    public function image(Request $request): Response
    {
        $imageRequest = ImageRequest::create($request);
        $resolution = $this->resolutionService->createFromRequest($imageRequest);

        return $this->placeholderGenerator->generate(
            $resolution->getWidth(),
            $resolution->getHeight(),
            $imageRequest->getText(),
            $imageRequest->getTextSize(),
            $imageRequest->getColorText(),
            $imageRequest->getColorBg()
        );
    }
}
