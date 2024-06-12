<?php

namespace App\DataFixtures;

use App\Entity\Stock;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StockFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $stock = $manager->getRepository(Stock::class)->findAll();

        $this->createStock(size: '3 mois', manager: $manager, stockProducts: 5);
        $this->createStock(size: '6 mois', manager: $manager, stockProducts: 5);
        $this->createStock(size: '9 mois', manager: $manager, stockProducts: 5);
        $this->createStock(size: '1 an', manager: $manager, stockProducts: 5);
        $this->createStock(size: '2 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '18 mois', manager: $manager, stockProducts: 5);
        $this->createStock(size: '2 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '3 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '4 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '5 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '6 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '8 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '10 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '12 ans', manager: $manager, stockProducts: 5);
        $this->createStock(size: '14 ans', manager: $manager, stockProducts: 5);

        $manager->flush();
    }

    public function createStock(string $size, int $stockProducts, ObjectManager $manager): void
    {
        $stock = new Stock();

        $stock->setSize($size)
            ->setStockProducts($stockProducts);

        $manager->persist($stock);
    }
}
