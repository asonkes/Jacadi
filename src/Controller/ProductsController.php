<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/{slug}', name: 'index')]
    public function index(ProductsRepository $productsRepository, CategoriesRepository $categoriesRepository, string $slug, Request $request): Response
    {
        // On va chercher le numéro de la page dans l'url
        $page = $request->query->getInt('page', 1);

        // Récupérer la catégorie par le slug
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        // Récupérer les produits de cette catégorie
        $products = $productsRepository->findProductsPaginated($page, $category, 6);

        return $this->render('products/index.html.twig', [
            'products' => $products,
            'category' => $category,
        ]);
    }
}
