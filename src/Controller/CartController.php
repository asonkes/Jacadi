<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\StockRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository, StockRepository $stockRepository, SessionInterface $session)
    {
        // Récupérer le panier depuis la session
        $panier = $session->get('panier', []);

        // On initialise des variables
        $data = [];
        $total = 0;

        // Parcourir chaque élément du panier
        foreach ($panier as $id => $quantity) {
            $product = $productsRepository->find($id);

            if ($product) {
                // Convertir le prix en nombre (float)
                $price = (float) $product->getPrice();

                // Vérifier si $quantity est numérique
                if (is_numeric($quantity)) {
                    // Récupérer les stocks associés au produit
                    $stocks = $stockRepository->findBy(['products' => $product]);

                    $data[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'stocks' => $stocks, // Ajouter les stocks au tableau de données
                    ];

                    // Calculer le total
                    $total += $price * (int) $quantity;
                } else {
                    // Gérer l'erreur si $quantity n'est pas numérique
                }
            } else {
                // Gérer l'erreur si le produit n'est pas trouvé
            }
        }

        return $this->render('cart/index.html.twig', [
            'data' => $data,
            'total' => $total,
        ]);
    }

    #[Route('/ajout/{id}', name: 'add')]
    public function add(Products $product, SessionInterface $session)
    {
        // On récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On ajoute le produit dans le panier s'il n'y est pas encore
        // Sinon on incrémente sa quantité
        if (!isset($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        $session->set('panier', $panier);

        // On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Products $product, SessionInterface $session)
    {
        // On récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On retirer le produit du panier s'il n'y a qu'1 exemplaire
        // Sinon on décrémente sa quantité
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        // On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $product, SessionInterface $session)
    {
        // On récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        // On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        // On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }
}
