<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController
{
    #[Route('/')]
    public function homepage()
    {
        return new Response('<strong>Starshop</strong>: your monopoly-busting option for Starship parts!');
    }

    #[Route('/about')]
    public function about(): Response
    {
        return new Response('Starshop is a new online store for Starship parts. We are here to help you find the parts you need to keep your Starship flying!');
    }
}
