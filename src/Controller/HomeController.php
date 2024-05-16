<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/home/products', name: 'products')]
    public function products(): Response
    {
        return $this->render('home/products.html.twig');
    }

    #[Route('/home/articles', name: 'articles')]
    public function articles(): Response
    {
        return $this->render('home/articles.html.twig');
    }
}
