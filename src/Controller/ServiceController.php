<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', 'service.index', methods:['GET'])]
    public function index(CategorieRepository $categorieRepository): response
    {
        //Todo
        $lesCategories = $categorieRepository->findAll();

        return $this->render(
            'service/index.html.twig',
            ['lesCategories' =>$lesCategories]
        );
    }

    #[Route('/service/liste/{id}', 'service.liste', methods:['GET'])]
    public function liste(
        ServiceRepository $serviceRepository,
        CategorieRepository $categorieRepository,
        $id
    ): response {
        //Todo
        $laCategorie = $categorieRepository->findByNumero($id);

        $lesServices = $serviceRepository->findAll();
        $lesServicesSelonUneCategorie = new ArrayCollection([]);
        foreach ($lesServices as $value) {


            if($value->getNumerocat()->getNumerocat() == (int)$id) {
                $lesServicesSelonUneCategorie->add($value);
            }
        }
        return $this->render(
            'service/liste.html.twig',
            ['lesServices' =>$lesServicesSelonUneCategorie, 'laCategorie' =>$laCategorie]
        );
    }

    #[Route('/service/detail/{id}', 'service.detail', methods:['GET'])]
    public function detail(
        ServiceRepository $serviceRepository,
        $id
    ): response {
        //Todo
        $leService = $serviceRepository->findByReference($id);

        return $this->render('service/detail.html.twig', ['leService'=> $leService]);
    }
}
