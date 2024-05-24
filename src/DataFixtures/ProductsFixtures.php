<?php

namespace App\DataFixtures;

use App\Entity\Products;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Créez des produits avec des dates spécifiques ou par défaut à la date actuelle
        $this->createProduct(title: 'T-shirt Rayé Bleu', price: 15.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'TW12071-13_TW22031-78_1 (3).jpg', manager: $manager,);

        $this->createProduct(title: 'ensemble marine', price: 55.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'Henri.jpg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 14.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'TW10023-43_TW26023-52_1_1024x.jpg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 20.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'pexels-photo-4563009.jpeg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 21.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'packshot-garcon_1024x.jpg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 18.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'pexels-photo-15466102.jpeg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 20.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'TW12023-13_TW26023-04_1_1.jpg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 21.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'pexels-photo-1427288.jpg', manager: $manager);

        $this->createProduct(title: 'ensemble marine', price: 55.00, createdAt: new DateTimeImmutable('2024-05-23'), updatedAt: new DateTimeImmutable('2024-05-23'), image: 'Hector.jpg', manager: $manager);

        $manager->flush();
    }

    public function createProduct(string $title, float $price, DateTimeImmutable $createdAt = null, DateTimeImmutable $updatedAt = null, string $image, ObjectManager $manager)
    {
        $product = new Products();

        /**
         * Si "createAt ou updateDate" sont nulles, automatiquement l'heure et date actuelle sont insérées.
         */
        $createdAt = $createdAt ?? new DateTimeImmutable();
        $updatedAt = $updatedAt ?? new DateTimeImmutable();

        $product->setTitle($title)
            /**
             * Chaque slug a un slug unique, basé sur son titre et le texte reste en minuscule.
             */
            ->setSlug($this->slugger->slug($product->getTitle())->lower())
            ->setPrice($price)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setImage($image);

        $manager->persist($product);

        return $product;
    }
}
