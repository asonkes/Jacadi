<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/{slug}', name: 'index')]
    public function index(ProductsRepository $productsRepository, CategoriesRepository $categoriesRepository, string $slug): Response
    {
        // Récupérer la catégorie par le slug, findOneBy ne retourne qu'une seule donnée.
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        // Récupérer les produits de cette catégorie
        $products = $productsRepository->findBy(['categories' => $category]);

        return $this->render('products/index.html.twig', [
            'products' => $products,
            'category' => $category
        ]);
    }
}
