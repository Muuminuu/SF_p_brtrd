<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app.home');
        }
        return $this->render('Security/login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'lastUsername' => $authUtils->getLastUsername()
        ]);
    }

    // #[Route('/register', name: 'app.register', methods: ['GET', 'POST'])]
    // public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    // {
    //     $user = new User();

    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()) {

    //         $user->setPassword(
    //             $passwordHasher->hashPassword($user, $form->get('password')->getData())
    //         );

    //         $em->persist($user);
    //         $em->flush();

    //         $this->addFlash('success', 'Votre compte a bien été crée');

    //         return $this->redirectToRoute('app.login');
    //     }

    //     return $this->render('Security/register.html.twig', [
    //         'form' => $form
    //     ]);
    // }
}
