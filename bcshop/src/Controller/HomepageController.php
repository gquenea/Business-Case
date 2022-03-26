<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('homepage/index.html.twig', [
            'products'=>$repository->findAll(),
        ]);
    }
}
