<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @Route("/user/{id}", methods="GET")
     */
    public function index(int $id, UserRepository $userRepository)
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
    public function create(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, [
            'entity_manager' => $entityManager,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $encoded = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $user->setPassword($encoded);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->respond($userRepository->transform($user));
        }

        return $this->respondWithFormErrors($form);
    }

    /**
     * @Route("/user/{id}", methods="POST")
     */
    public function update(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOne($request->get('id'));
        if ($user === null) {
            return $this->respondNotFound();
        }

        $form = $this->createForm(UserType::class, $user, [
            'entity_manager' => $entityManager,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $encoded = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $user->setPassword($encoded);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->respond($userRepository->transform($user));
        }

        return $this->respondWithFormErrors($form);
    }

    /**
     * @Route("/user/{id}", methods="DELETE")
     */
    public function delete(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOne($request->get('id'));
        if ($user === null) {
            return $this->respondNotFound();
        }

        $user->setRemovedAt(new \DateTime());

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->respond([]);
    }
}