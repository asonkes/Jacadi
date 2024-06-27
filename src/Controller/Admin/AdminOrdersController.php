<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
#[IsGranted('ROLE_ADMIN')]
class AdminOrdersController extends AbstractController
{
    #[Route('/commandes', name: 'orders')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $orders = $entityManager->getRepository(Orders::class)->findAll();

        return $this->render('admin/orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/commandes/supprimer/{id}', name: 'order_delete', methods: ['POST'])]
    public function delete(Orders $order, EntityManagerInterface $entityManager): Response
    {
        // Parcourir chaque détail de commande associé à la commande
        foreach ($order->getOrdersDetails() as $detail) {
            $product = $detail->getProducts();
            $quantity = $detail->getQuantity();

            // Mettre à jour le stock
            $stock = $entityManager->getRepository(Stock::class)->findOneBy([
                'products' => $product,
                'size' => $detail->getSize() // Assurez-vous de gérer les tailles si nécessaire
            ]);

            if ($stock) {
                $currentStock = $stock->getStockProducts();
                $newStock = $currentStock - $quantity;
                $stock->setStockProducts($newStock);

                $entityManager->persist($stock);
            }

            // Supprimer chaque détail de commande
            $entityManager->remove($detail);
        }

        // Supprimer la commande elle-même
        $entityManager->remove($order);
        $entityManager->flush();

        $this->addFlash('success', 'La commande a été supprimée.');

        return $this->redirectToRoute('admin_orders');
    }

    #[Route('/commandes/{id}', name: 'order_detail')]
    public function detail(Orders $order): Response
    {
        return $this->render('admin/orders/detail.html.twig', [
            'order' => $order,
        ]);
    }
}
