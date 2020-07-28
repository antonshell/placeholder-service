<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(Request $request): Response
    {
        return new JsonResponse([
            'status' => 'ok',
            'service' => 'placeholder service',
        ]);
    }

    public function image(Request $request): Response
    {
        return new JsonResponse([
            'resolution' => $request->get('resolution'),
            'extension' => $request->get('ext', 'png'),
            'text' => $request->get('text', 'text'),
            'color_text' => $request->get('color_text', 'fff'),
            'color_bg' => $request->get('color_bg', 'fff'),
        ]);
    }
}
