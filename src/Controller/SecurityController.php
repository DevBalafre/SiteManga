<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
  
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
            
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
             'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/utlisateur/editPassword/{id}", name="editPassword") 
     */
    public function editPassword(User $user, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher): Response
    {

        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->get('plainPassword')->getData())) {
                $manager = $doctrine->getManager();
                $user->setPassword($hasher->hashPassword($user, $form->get('newPassword')->getData()));
                $manager->flush();
                $this->addFlash('sucess', 'Profile mis à jour');
                // lorsque je sauvegarde la modif je fait une redirection
                return $this->redirectToRoute("app_user");
            } else {
                $this->addFlash(
                    'error',
                    'Le mot de passe renseigné est incorect'
                );
            }
        }


        return $this->render('security/editPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
