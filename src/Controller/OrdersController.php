<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if ($panier === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('home');
        }

        // Le panier n'est pas vide, on crée la commande
        $order = new Orders();

        // On remplit la commande 
        $order->setUsers($this->getUser());
        $order->setReference(uniqid());

        // On parcourt le panier pour créer les détails de la commande
        foreach ($panier as $key => $details) {
            $orderDetails = new OrdersDetails();

            // Récupérer l'ID du produit et la taille à partir de la clé composite
            list($productId, $size) = explode('_', $key);

            // On va chercher le produit
            $product = $productsRepository->find($productId);

            $price = $product->getPrice();

            // On crée le détail de commande
            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($details['quantity']);
            $orderDetails->setSize($details['size']);  // Ajouter la taille

            $order->addOrdersDetail($orderDetails);
        }

        // On persiste et on flush
        $entityManager->persist($order);
        $entityManager->flush();

        $session->remove('panier');

        $this->addFlash('success', 'Votre commande a été créé avec succès');

        return $this->redirectToRoute('home');
    }
}
