<?php

namespace App\Controller;

use Mpdf\Mpdf;
use App\Repository\CommandeRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    #[Route('/facture/{id}', 'facture.index', methods:['GET'])]
    public function index(
        $id,
        CommandeRepository $commandeRepository
    ): Response {
        $laCommande = $commandeRepository->findOneBy(['login'=>$this->getUser()->getUsername(),
                                                      'nocommande'=>$id]);
        $mpdf = new Mpdf();

        $html = $this->renderView('facture/index.html.twig', [
            'laCommande'=>$laCommande,
        ]);

        $mpdf->WriteHTML($html);

        $mpdf->Output('fichier.pdf', 'D');

        return new Response();

        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }
}
