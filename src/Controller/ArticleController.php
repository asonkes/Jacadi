<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article', name: 'article_')]
class ArticleController extends AbstractController
{
    #[Route('/{slug}_{id}', name: 'index')]
    public function index(Products $products): Response
    {
        return $this->render('article/index.html.twig', [
            'product' => $products
        ]);
    }
}
