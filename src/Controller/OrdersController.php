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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if ($panier === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('home');
        }

        // Générer le numéro de référence unique
        $orderRepository = $entityManager->getRepository(Orders::class);
        $lastOrder = $orderRepository->findOneBy([], ['id' => 'desc']);
        $lastId = $lastOrder ? $lastOrder->getId() + 1 : 1;
        $reference = sprintf('%s-%s-%04d', date('Y'), date('m'), $lastId);

        // Créer la commande
        $order = new Orders();
        $order->setUsers($this->getUser());
        $order->setReference($reference);

        $total = 0; // Initialiser le total de la commande

        // Parcourir le panier pour créer les détails de la commande
        foreach ($panier as $key => $details) {
            $orderDetails = new OrdersDetails();

            // Récupérer l'ID du produit et la taille à partir de la clé composite
            list($productId, $size) = explode('_', $key);

            // Récupérer le produit
            $product = $productsRepository->find($productId);

            // Créer le détail de commande
            $price = $product->getPrice();
            $quantity = $details['quantity'];
            $total += $price * $quantity; // Ajouter au total

            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);
            $orderDetails->setSize($size);

            $order->addOrdersDetail($orderDetails);
        }

        // Persister et flush
        $entityManager->persist($order);
        $entityManager->flush();

        // Vider le panier
        $session->remove('panier');

        // Envoyer l'email de confirmation
        $this->sendOrderConfirmationEmail($order, $total, $mailer);

        $this->addFlash('success', 'Votre commande a été créée avec succès et un email de confirmation a été envoyé.');

        return $this->redirectToRoute('home');
    }

    private function sendOrderConfirmationEmail(Orders $order, float $total, MailerInterface $mailer)
    {
        $user = $order->getUsers();
        $email = (new Email())
            ->from(new Address('no-reply@yourdomain.com', 'Your Shop'))
            ->to($user->getEmail())
            ->subject('Confirmation de commande')
            ->html($this->renderView('emails/order_confirmation.html.twig', [
                'order' => $order,
                'user' => $user,
                'total' => $total
            ]));

        $mailer->send($email);
    }
}
