<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    /**
     * @var ManagerRegistry
     */
    public $entityManager ;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }
    
    /**
     * show list of all users 
     * @param UserRepository $userRepository
     * @Route("/users", name="user_list")
     */
    public function listAction(UserRepository $userRepository)
    {
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * create a user 
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request,UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $userPasswordHasher->hashPassword($user,$user->getPassword());
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success',"L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * update a user 
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request,UserPasswordHasherInterface $userPasswordHasher)
    {
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $userPasswordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->entityManager->flush();

            $this->addFlash('success',"L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(),'user' => $user]);
    }
}
