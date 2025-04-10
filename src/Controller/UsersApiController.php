<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UsersApiController extends AbstractController
{
    #[Route('/api/users', methods: ['GET'])]
    public function getCollection(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->json($users);
    }

    #[Route('/api/users/{id<\d+>}', methods: ['GET'])]
    public function getUsers(UserRepository $repository, int $id): Response
    {
        $user = $repository->findById($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user);
    }
}