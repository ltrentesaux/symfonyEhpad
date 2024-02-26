<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\ServiceRepository;
use App\Repository\CommandeRepository;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PanierController extends AbstractController
{
    #[Route('/panier', 'panier.index', methods:['GET'])]
    public function index(
        ServiceRepository $serviceRepository,
        SessionInterface $session
    ): response {
        $lesProduits=[];
        foreach($session->get('produit') as $cle => $value) {
            $leService = $serviceRepository->find($cle);
            if($leService != null) {
                $lesProduits[]=$leService;
            }
        }
        return $this->render('panier/index.html.twig', ['lesServices' => $lesProduits]);
    }

    #[Route('/panier/ajouter/{id}', 'panier.ajouter', methods:['GET'])]
    public function ajouter($id, SessionInterface $session)
    {
        //Création d'une variable de session produit si elle n'existe pas
        if($session->get('produit') == null) {
            $session->set('produit', []);
        }
        /*Création d'une variable temporaire pour faciliter la
        manipulation */
        $temp=$session->get('produit', []);
        //Création d'une variable pour spécifier la valeur retour
        $test=false;
        //Vérification que l'id du service n'est pas déjà enregistrer
        foreach($temp as $key=>$value) {
            if($key == $id) {
                $test=true;
            }
        }
        if($test) {
            return new JsonResponse(['success' => false]);
        } else {
            /*S'il n'est pas enregistré, on l'enregistre dans la variable
            de session*/
            $temp[$id]=1;
            $session->set('produit', $temp);
            $session->set('produitTotal', count($session->get('produit')));
            return new JsonResponse(['success' => true]);
        }
    }

    #[Route('/panier/supprimer/{id}', 'panier.supprimer', methods:['GET'])]
    public function supprimer($id, SessionInterface $session)
    {
        $tab= $session->get('produit');
        unset($tab[$id]);
        $session->set('produit', $tab);
        $session->set('produitTotal', count($session->get('produit')));
        return new JsonResponse(['success' => true]);
    }

    #[Route('/commande', 'panier.commande', methods:['GET','POST'])]
    public function commande(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        Request $request,
        CommandeRepository $commandeRepository,
        ClientRepository $clientRepository,
        ServiceRepository $serviceRepository
    ): response {
        if($request->request->get('valider')) {
            $client = $clientRepository->find($this->getUser()->getUsername());

            $laCommande = new Commande();

            $laCommande->setLogin($client);
            //dd($session->get('produit'));
            foreach ($session->get('produit') as $key=>$value) {
                $laCommande->addReference($serviceRepository->find($key));
            }
            $commandeRepository->save($laCommande, true);

            $derniereCommande = $commandeRepository->findLast();

            $connection = $entityManager->getConnection();

            foreach ($session->get('produit') as $key => $value) {
                $sql='UPDATE lignecommande l set l.QTITE="'.$value.'"where l.nocommande="'
                .$derniereCommande->getNoCommande().'"AND l.reference = "'.$key.'";';

                $result = $connection->executeQuery($sql, []);
            }

            $session -> remove('produit');
            $session -> remove('produitTotal');
            $session -> remove('totalPanier');

            return new RedirectResponse('service', 302, []);
        }
        //Todo
        return $this->render('panier/commande.html.twig');
    }

    public function save(Panier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Panier $entity, bool $flush = false): void
    {
        //dd($this->getEntityManager());
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
