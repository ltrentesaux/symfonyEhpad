<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\DroitRepository;
use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Security\Authenticator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\User;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/inscription', name: 'app_register')]
    public function register(
        Request $request,
        ManagerRegistry $entityManager,
        AuthenticationUtils $authenticationUtils,
        PersonneRepository $personneRepository
    ): Response {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //Tester le poste de variales
        if($request->request->get('username')) {
            $personne= new Personne();

            $username= $request->request->get('username');
            $password= $request->request->get('password');
            //dd($username);
            $personne->setLogin($username);
            $personne->setMdp($password);

            $numDroit=new DroitRepository($entityManager);
            $personne->setNumDroit($numDroit->find(2));
            // dd($personne);
            try {
                $personneRepository->save($personne, true);
            } catch(Exception) {
                return $this->render(
                    'security/register.html.twig',
                    ['last_username' => $lastUsername,
                    'error' => $error,
                    'message' => 'Ce login est déjà pris !']
                );
            }

            if($personneRepository->findOneBy(['login'=>$username]) != null) {

                return new RedirectResponse('connexion', 302, [
                    'last_username'=> $lastUsername,
                    'error' => $error,
                    'message' => 'Veuillez vous logger !'
                ]);
            } else {
                return $this->render('security/register.html.twig', [
                    'last_username'=> $lastUsername,
                    'error' => $error,
                    'message' => 'Un erreur est survenue'
                ]);
            }

            return $this->render('security/register.html.twig', [
                'last_username'=> $lastUsername,
                'error' => $error,
                'message' => ''
            ]);
        }

        return $this->render('security/register.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
