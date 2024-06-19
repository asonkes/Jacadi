<?php

namespace App\Controller\Admin;

use App\Repository\ProductsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository, CategoriesRepository $categoriesRepository): Response
    {
        // Pemet de récupérer les produits de la base de données
        $product = $productsRepository()->findAll();

        $categories = $categoriesRepository->findBy([]);

        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }
}
