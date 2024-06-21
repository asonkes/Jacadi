<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\StockRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
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
        foreach ($panier as $id => $details) {
            $product = $productsRepository->find($id);

            if ($product && is_array($details) && isset($details['quantity']) && isset($details['size'])) {
                // Convertir le prix en nombre (float)
                $price = (float) $product->getPrice();

                // Vérifier si $details['quantity'] est numérique
                if (is_numeric($details['quantity'])) {
                    // Récupérer les stocks associés au produit
                    $stocks = $stockRepository->findBy(['products' => $product]);

                    $data[] = [
                        'product' => $product,
                        'quantity' => $details['quantity'],
                        'size' => $details['size'], // Ajouter la taille au tableau de données
                        'stocks' => $stocks,
                    ];

                    // Calculer le total
                    $total += $price * (int) $details['quantity'];
                }
            }
        }

        return $this->render('cart/index.html.twig', [
            'data' => $data,
            'total' => $total,
        ]);
    }

    #[Route('/ajout/{id}', name: 'add', methods: ['POST'])]
    public function add(Request $request, Products $product, SessionInterface $session)
    {
        $id = $product->getId();
        $size = $request->request->get('size');

        // Récupérer le panier existant
        $panier = $session->get('panier', []);

        // Utiliser une clé composite pour le produit et la taille
        $key = $id . '_' . $size;

        if (!isset($panier[$key])) {
            $panier[$key] = [
                'quantity' => 1,
                'size' => $size,
                'product_id' => $id,
            ];
        } else {
            $panier[$key]['quantity']++;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['POST'])]
    public function remove(Request $request, Products $product, SessionInterface $session)
    {
        $id = $product->getId();
        $size = $request->request->get('size');

        // Ajoutez une déclaration de débogage ici
        if (!$size) {
            throw new \Exception('La taille n\'a pas été transmise correctement.');
        }

        $key = $id . '_' . $size;

        $panier = $session->get('panier', []);

        if (isset($panier[$key])) {
            $panier[$key]['quantity']--;

            if ($panier[$key]['quantity'] <= 0) {
                unset($panier[$key]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, SessionInterface $session)
    {
        $id = $product->getId();
        $size = $request->request->get('size');

        // Ajoutez une déclaration de débogage ici
        if (!$size) {
            throw new \Exception('La taille n\'a pas été transmise correctement.');
        }

        $key = $id . '_' . $size;

        $panier = $session->get('panier', []);

        if (isset($panier[$key])) {
            unset($panier[$key]);
        }

        $session->set('panier', $panier);

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
