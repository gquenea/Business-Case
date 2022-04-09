<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    private $session;
    private $repository;

    public function __construct(SessionInterface $session, ProductRepository $repository){
        $this->sesion = $session;
        $this->repository = $repository;
    }

    public function getCart(){
        $cart = $this->session->get("panier",[]);

        $cartObject = [];

        foreach ($cart as $productId=>$quantity){
            $item = ['product'=>$this->repository->find($productId),
                'quantity'=>$quantity];
            $cartObject[]=$item;
        }
        return $cartObject;
    }
}
