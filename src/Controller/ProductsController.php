<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/garcon', name: 'boy')]
    public function boy(ProductsRepository $repo): Response
    {
        /**
         * Permet de récupérer tous les produits
         */
        $products = $repo->findAll();

        return $this->render('products/boy.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/bebeGarcon', name: 'youngBoy')]
    public function youngBoy(ProductsRepository $repo): Response
    {
        $products = $repo->findAll();

        return $this->render('products/youngBoy.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/fille', name: 'girl')]
    public function girl(ProductsRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->render('products/girl.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/bebeFille', name: 'youngGirl')]
    public function youngGirl(ProductsRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->render('products/youngGirl.html.twig', [
            'products' => $products
        ]);
    }
}
