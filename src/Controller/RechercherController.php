<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercherController extends AbstractController
{
    #[Route('/rechercher', 'recherche.index', methods:['POST','GET'])]
    public function index(
        ServiceRepository $serviceRepository,
        Request $request
    ): Response {
        $lesServices = $serviceRepository->findByRecherche($request->request->get('n_cherche'));
        //dd($request);

        return $this->render('rechercher/index.html.twig', [
            'lesServices'=>$lesServices
        ]);
    }
}
