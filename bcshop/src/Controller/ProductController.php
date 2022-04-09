<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('product/editAddress.html.twig', [
            'products'=>$repository->findAll(),
        ]);
    }


}
