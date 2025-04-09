<?php

namespace App\Controller;

use App\Repository\StarshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name:'app_homepage')]
    public function homepage(StarshipRepository $starshipRepository): Response
    {
        $ships = $starshipRepository->findAll();
        $myShip = $ships[array_rand($ships)];
        return $this->render('main/homepage.html.twig', [
            'ships' => $ships,
            'myShip' => $myShip,
        ]);
    }

    #[Route('/about')]
    public function about(): Response
    {
        return new Response('Starshop is a new online store for Starship parts. We are here to help you find the parts you need to keep your Starship flying!');
    }
}
