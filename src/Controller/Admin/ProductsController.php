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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class ProductsController extends AbstractController
{
    #[Route('/produits', name: 'products')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Products $products, ProductsRepository $productsRepository): Response
    {
        // Permet ici de récupérer tous les produits pour le dashboard
        $products = $productsRepository->findAll();

        return $this->render('admin/products/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/produits/ajout', name: 'add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(Products $products, Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On créé un "nouveau produit"
        $product = new $products();

        // On créé le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            // Génère le slug
            $slug = $slugger->slug($product->getName())->lower();
            $product->setSlug($slug);

            // Traite le téléchargement de l'image
            $imageFile = $productForm->get('image')->getData();
            if ($imageFile instanceof UploadedFile) {
                try {
                    // Créer une image à partir du fichier téléchargé
                    $image = imagecreatefromstring(file_get_contents($imageFile->getPathname()));

                    // Chemin pour sauvegarder l'image WebP
                    $webpFilename = $slugger->slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . uniqid() . '.webp';
                    $webpFilePath = $this->getParameter('image_dir') . '/' . $webpFilename;

                    // Convertir en WebP
                    imagewebp($image, $webpFilePath);

                    // Libérer la mémoire utilisée par l'image
                    imagedestroy($image);

                    // Mettre à jour le nom du fichier dans l'entité produit avec le fichier WebP
                    $product->setImage($webpFilename);
                } catch (\Exception $e) {
                    // Gérer l'exception si quelque chose se passe mal lors de la conversion
                }
            }

            // Persister les entités de stock associées
            foreach ($product->getStocks() as $stock) {
                $stock->setProducts($product);
                $entityManagerInterface->persist($stock);
            }

            // On stocke
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            // On redirige

            return $this->redirectToRoute('admin_add');
        }

        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView(),
            'product' => $product
        ]);
    }

    #[Route('/produits/edition/{id}', name: 'edit')]
    #[IsGranted('ROLE_ADMIN')]
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
            // Génère le slug
            $slug = $slugger->slug($product->getName())->lower();
            $product->setSlug($slug);

            // Traite le téléchargement de l'image
            $imageFile = $productForm->get('image')->getData();
            if ($imageFile instanceof UploadedFile) {
                try {
                    // Créer une image à partir du fichier téléchargé
                    $image = imagecreatefromstring(file_get_contents($imageFile->getPathname()));

                    // Chemin pour sauvegarder l'image WebP
                    $webpFilename = $slugger->slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . uniqid() . '.webp';
                    $webpFilePath = $this->getParameter('image_dir') . '/' . $webpFilename;

                    // Convertir en WebP
                    imagewebp($image, $webpFilePath);

                    // Libérer la mémoire utilisée par l'image
                    imagedestroy($image);

                    // Mettre à jour le nom du fichier dans l'entité produit avec le fichier WebP
                    $product->setImage($webpFilename);
                } catch (\Exception $e) {
                    // Gérer l'exception si quelque chose se passe mal lors de la conversion
                }
            }

            // Persister les entités de stock associées
            foreach ($product->getStocks() as $stock) {
                $stock->setProducts($product);
                $entityManagerInterface->persist($stock);
            }

            // On stocke
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            // On redirige

            return $this->redirectToRoute('admin_add');
        }

        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView(),
            'product' => $product
        ]);
    }

    #[Route('/produits/suppression', name: 'delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Products $product): Response
    {
        // On vérifie si l'utilisateur peut delete avec le voter
        $this->denyAccessUnlessGranted('DELETE_EDIT', $product);
        return $this->render('admin/products/delete.html.twig');
    }
}
