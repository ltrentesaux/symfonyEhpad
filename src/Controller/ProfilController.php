<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClientRepository;
use App\Repository\DroitRepository;
use App\Repository\PersonneRepository;
use App\Repository\CommandeRepository;
use App\Entity\Droit;
use App\Entity\Client;
use Symfony\Component\Asset\Package;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', 'profil.index', methods:['GET','POST'])]
    public function index(
        ClientRepository $clientRepository,
        DroitRepository $droitRepository,
        PersonneRepository $personneRepository,
        CommandeRepository $commandeRepository,
        Request $request
    ): Response {
        $clientr = $clientRepository->find($this->getUser()->getUsername());
        $personne = $personneRepository->findOneBy(['login'=> $this->getUser()->getUsername()]);
        //dd($clientr);

        $numDroit = $personne->getNumDroit()->getNumDroit();
        //dd($numDroit);
        // $numDroit = new Droit();

        $droit = $droitRepository->findOneBy(['numdroit'=>$numDroit]);
        //dd($droit);
        $personne->setNumDroit($droit);


        $lesCommandes = $commandeRepository->findBy(['login'=>$this->getUser()->getUsername()]);
        $message="";

        if($clientr == null) {
            $client = new Client();

            $client->setLogin($personne);

        } else {
            $client = $clientr;
        }

        if ($request->request->get('valider')) {
            $personne->setLogin($request->request->get('login'));
            $personne->setMdp($request->request->get('mdp'));

            $client->setNom($request->request->get('nom'));
            $client->setPrenom($request->request->get('prenom'));
            $client->setRue($request->request->get('rue'));
            $client->setCp($request->request->get('cp'));
            $client->setVille($request->request->get('ville'));
            $client->setTel($request->request->get('tel'));
            $client->setEmail($request->request->get('email'));
            $client->setLogin($personne);

            $personneRepository->save($personne, true);
            $clientRepository->save($client, true);
            $message= 'Les modifications sont correctement enregistrées';


 

            


        }
        //allergies
       // $jsonContent = file_put_contents('asset/js/allergies.json', $data);
      //  $dataArray = json_decode($jsonContent, true);

      //  dd($dataArray);

        return $this->render('profil/index.html.twig', [
            'client'=>$client,
            'lesCommandes'=>$lesCommandes,
            'message'=>$message,

            //allergies
            'allergies'=> array(["num"=>"1","nom"=>"al"],["num"=>"1","nom"=>"al"])
        ]);
    }
}
