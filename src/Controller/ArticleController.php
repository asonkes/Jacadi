<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use App\Repository\StockRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/details', name: 'article_')]
class ArticleController extends AbstractController
{
    private $productsRepository;
    private $stockRepository;
    private $categoriesRepository;

    public function __construct(ProductsRepository $productsRepository, StockRepository $stockRepository, CategoriesRepository $categoriesRepository)
    {
        $this->productsRepository = $productsRepository;
        $this->stockRepository = $stockRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    #[Route('/{slug}_{id}', name: 'index')]
    public function index(int $id): Response
    {
        // Récupérer le produit par son ID
        $product = $this->productsRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }

        // Récupérer les stocks associés à ce produit
        $stocks = $this->stockRepository->findBy(['products' => $product]);

        // Récupérer les catégories associées au produit
        $categories = $product->getCategories();

        return $this->render('article/index.html.twig', [
            'product' => $product,
            'stocks' => $stocks,
            "categories" => $categories
        ]);
    }
}
