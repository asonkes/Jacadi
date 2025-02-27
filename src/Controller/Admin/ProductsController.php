<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
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
    public function add(Stock $stock, Products $products, Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On créé un "nouveau produit"
        $product = new $products();

        // Initialiser les tailles par défaut
        $sizes = ['3 mois', '6 mois', '9 mois', '1 an', '2 ans', '18 mois', '3 ans', '4 ans', '5 ans', '6 ans', '8 ans', '10 ans', '12 ans', '14 ans'];

        foreach ($sizes as $size) {
            $stock = new Stock();
            $stock->setSize($size);
            $stock->setStockProducts(0);
            $stock->setProducts($product);
            $product->addStock($stock);
        }

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
                    $this->addFlash('error', 'Une erreur s\'est produite lors de l\'ajout du produit : ' . $e->getMessage());
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
            $this->addFlash('success', 'Produit modifié avec succès');

            // On redirige
            return $this->redirectToRoute('admin_add');
        }

        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView(),
            'product' => $product
        ]);
    }

    #[Route('/produits/suppression/{id}', name: 'delete', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur peut supprimer le produit
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);

        // Vérifie le token CSRF pour sécuriser la requête de suppression
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->query->get('_token'))) {
            // Récupère tous les stocks associés au produit
            $stocks = $product->getStocks();

            try {
                // Supprime chaque stock associé au produit
                foreach ($stocks as $stock) {
                    $entityManager->remove($stock);
                }

                // Supprime le produit lui-même
                $entityManager->remove($product);
                $entityManager->flush();

                $this->addFlash('success', 'Produit supprimé avec succès');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur s\'est produite lors de la suppression du produit : ' . $e->getMessage());
            }
        } else {
            $this->addFlash('error', 'Le jeton CSRF est invalide.');
        }

        // Redirige vers la liste des produits
        return $this->redirectToRoute('admin_products');
    }
}
