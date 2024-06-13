<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsFormType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class ProductsController extends AbstractController
{
    #[Route('/produits', name: 'products')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/produits/ajout', name: 'add')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function add(Products $products, Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN_CLIENT');

        // On créé un "nouveau produit"
        $product = new $products();

        // On créé le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            // On génère le slug
            $slug = $slugger->slug($product->getName())->lower();
            $product->setSlug($slug);

            // On arrondi le prix 
            $prix = $product->getPrice();
            $product->setPrice($prix);

            // On stocke
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            // On redirige

            return $this->redirectToRoute('admin_add');
        }

        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/produits/edition/{id}', name: 'edit')]
    #[IsGranted('ROLE_ADMIN_CLIENT')]
    public function edit(Products $product, request $request, SluggerInterface $slugger, EntityManagerInterface $entityManagerInterface): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        // On créé le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            // On génère le slug
            $slug = $slugger->slug($product->getName())->lower();
            $product->setSlug($slug);

            // On arrondi le prix 
            $prix = $product->getPrice();
            $product->setPrice($prix);

            // On stocke
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Produit modifié avec succès');

            // On redirige

            return $this->redirectToRoute('admin_add');
        }

        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView()
        ]);
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