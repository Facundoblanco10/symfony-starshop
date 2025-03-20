<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        $starshipCount = 457;
        $myShip = [
            'name' => 'USS LeafyCruiser (NCC-0001)',
            'class' => 'Garden',
            'captain' => 'Jean-Luc Pickles',
            'status' => 'under construction',
        ];
        return $this->render('main/homepage.html.twig', [
            'numberOfStarships' => $starshipCount,
            'myShip' => $myShip,
        ]);
    }

    #[Route('/about')]
    public function about(): Response
    {
        return new Response('Starshop is a new online store for Starship parts. We are here to help you find the parts you need to keep your Starship flying!');
    }
}
