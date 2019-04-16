<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Components\Password\PasswordEncoder;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @Route("/user/{id}", methods="GET")
     */
    public function show(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->findOne($id);
        if ($user === null) {
            return $this->respondNotFound();
        }

        return $this->respond($userRepository->transform($user));
    }

    /**
     * @Route("/user", methods="POST")
     */
    public function create(
        Request $request,
        UserService $userService,
        UserRepository $userRepository,
        PasswordEncoder $passwordEncoder
    )
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userService->saveUser($form->getData(), $passwordEncoder);

            return $this->respond($userRepository->transform($user));
        }

        return $this->respondWithFormErrors($form);
    }

    /**
     * @Route("/user/{id}", methods="POST")
     */
    public function update(
        Request $request,
        UserRepository $userRepository,
        UserService $userService,
        PasswordEncoder $passwordEncoder
    )
    {
        $user = $userRepository->findOne($request->get('id'));
        if ($user === null) {
            return $this->respondNotFound();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userService->saveUser($form->getData(), $passwordEncoder);

            return $this->respond($userRepository->transform($user));
        }

        return $this->respondWithFormErrors($form);
    }

    /**
     * @Route("/user/{id}", methods="DELETE")
     */
    public function delete(Request $request, UserService $userService, UserRepository $userRepository)
    {
        $user = $userRepository->findOne($request->get('id'));
        if ($user === null) {
            return $this->respondNotFound();
        }

        $userService->deleteUser($user);

        return $this->respond([]);
    }
}