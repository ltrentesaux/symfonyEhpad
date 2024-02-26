<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', 'test.index', methods:['POST','GET'])]
    public function index(Request $request): Response
    {
        //dd($request->request->get('test'));
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
