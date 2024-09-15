<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortUrlController
{
    #[Route('/{number}', name: 'shortUrlBase62')]
    public function index($number): Response
    {
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $hashString = '';

        while ($number > 0) {
            $hashString = $string[$number % 62] . $hashString;
            $number /= 62;
        }

        return new JsonResponse(['base_encode' => $hashString]);
    }

}