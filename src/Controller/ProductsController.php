<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'boy')]
    public function boy(): Response
    {
        return $this->render('products/boy.html.twig');
    }

    #[Route('/youngBoy', name: 'youngBoy')]
    public function youngBoy(): Response
    {
        return $this->render('products/youngBoy.html.twig');
    }

    #[Route('/girl', name: 'girl')]
    public function girl(): Response
    {
        return $this->render('products/girl.html.twig');
    }

    #[Route('/youngGirl', name: 'youngGirl')]
    public function youngGirl(): Response
    {
        return $this->render('products/youngGirl.html.twig');
    }
}
