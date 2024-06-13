<?php

namespace App\DataFixtures;

use App\Entity\Stock;
use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StockFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupère tous les produits depuis la base de données
        $products = $manager->getRepository(Products::class)->findAll();

        // Vérifie s'il y a des produits dans la base de données
        if (!$products) {
            throw new \Exception('No products found in the database.');
        }

        // Itère sur chaque produit et crée des stocks pour chaque produit
        foreach ($products as $product) {
            $this->createStock('3 mois', 50, $product, $manager);
            $this->createStock('6 mois', 50, $product, $manager);
            $this->createStock('9 mois', 50, $product, $manager);
            $this->createStock('1 an', 50, $product, $manager);
            $this->createStock('2 ans', 50, $product, $manager);
            $this->createStock('18 mois', 50, $product, $manager);
            $this->createStock('3 ans', 50, $product, $manager);
            $this->createStock('4 ans', 50, $product, $manager);
            $this->createStock('5 ans', 50, $product, $manager);
            $this->createStock('6 ans', 50, $product, $manager);
            $this->createStock('8 ans', 50, $product, $manager);
            $this->createStock('10 ans', 50, $product, $manager);
            $this->createStock('12 ans', 50, $product, $manager);
            $this->createStock('14 ans', 50, $product, $manager);
        }

        // Sauvegarde tous les stocks créés dans la base de données
        $manager->flush();
    }

    public function createStock(string $size, int $stockProducts, Products $product, ObjectManager $manager): void
    {
        $stock = new Stock();
        $stock->setSize($size)
            ->setStockProducts($stockProducts)
            ->setProducts($product);

        $manager->persist($stock);
    }
}
