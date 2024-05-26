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
        /*
        // Créez des produits avec des dates spécifiques ou par défaut à la date actuelle
        $this->createProduct(name: 'T-shirt Rayé Bleu', price: 15.00, stock: 4, image: 'TW12071-13_TW22031-78_1 (3).jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Ensemble Marine', price: 55.00, stock: 4, image: 'Henri.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'T-shirt Logo', price: 14.00, stock: 4, image: 'TW10023-43_TW26023-52_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Chemise Bleu foncé', price: 20.00, stock: 4, image: 'pexels-photo-4563009.jpeg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Tartine et Chocolat', price: 21.00, stock: 4, image: 'packshot-garcon_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Chemise rayée blanche', price: 18.00, stock: 4, image: 'pexels-photo-15466102.jpeg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Chemise Rayée', price: 20.00, stock: 4, image: 'TW12023-13_TW26023-04_1_1.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Chemise colorée', price: 21.00, stock: 4, image: 'pexels-photo-1427288.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);

        $this->createProduct(name: 'Ensemble bleu clair', price: 55.00, stock: 4, image: 'Hector.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager);
        */


        $manager->flush();
    }

    public function createProduct(string $name, float $price, int $stock, string $image, ?DateTimeImmutable $createdAt = null, ObjectManager $manager)
    {
        $product = new Products();

        /**
         * Si "createAt ou updateDate" sont nulles, automatiquement l'heure et date actuelle sont insérées.
         */
        $createdAt = $createdAt ?? new DateTimeImmutable();

        $product->setName($name)
            /**
             * Chaque slug a un slug unique, basé sur son titre et le texte reste en minuscule.
             */
            ->setSlug($this->slugger->slug($product->getName())->lower())
            ->setPrice($price)
            ->setStock($stock)
            ->setImage($image)
            ->setCreatedAt($createdAt);

        $manager->persist($product);

        return $product;
    }
}
