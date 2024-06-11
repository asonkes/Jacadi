<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class ProductsController extends AbstractController
{
    #[Route('/produits', name: 'products')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/produits/ajout', name: 'add')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function add(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/produits/edition/{id}', name: 'edit')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function edit(Products $product): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/produits/suppression', name: 'delete')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function delete(Products $product): Response
    {
        // On vérifie si l'utilisateur peut delete avec le voter
        $this->denyAccessUnlessGranted('DELETE_EDIT', $product);
        return $this->render('admin/products/index.html.twig');
    }
}
