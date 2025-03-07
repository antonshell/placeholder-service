<?php

declare(strict_types=1);

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
    public function __construct(
        private PlaceholderGenerator $placeholderGenerator,
        private ResolutionService $resolutionService,
    ) {
    }

    public function index(): Response
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
            $imageRequest->getColorBg(),
            $imageRequest->getFormat()
        );
    }
}
