<?php

namespace App\Controller;

use App\Dto\CreateUserRequest;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    #[Route('/api/users', methods: ['POST'])]
    public function postUser(
        Request $request,
        UserRepository $repository,
        ValidatorInterface $validator
    ): Response {
        $data = json_decode($request->getContent(), true);
        $dto = CreateUserRequest::fromArray($data ?? []);

        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $created = $repository->create($dto->name, $dto->email, $dto->password);

        if (!$created) {
            return $this->json(['error' => 'User could not be created'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'message' => 'User created successfully'
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/users/{id<\d+>}', methods: ['DELETE'])]
    public function deleteUser(UserRepository $repository, int $id): Response
    {
        $deleted = $repository->deleteById($id);
        if (!$deleted) {
            return $this->json([
                'error' => 'User could not be deleted',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json([
            'message' => 'User deleted successfully',
        ], Response::HTTP_OK);
    }
}
