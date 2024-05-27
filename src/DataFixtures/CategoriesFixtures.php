<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Création des catégories sans hiérarchie parentale
        $this->createCategory(name: 'tShirtsYoungBoy', manager: $manager);
        $this->createCategory(name: 'tShirtsBoy', manager: $manager);
        $this->createCategory(name: 'tShirtsYoungGirl', manager: $manager);
        $this->createCategory(name: 'tShirtsGirl', manager: $manager);
        $this->createCategory(name: 'robesYoungGirl', manager: $manager);
        $this->createCategory(name: 'robesGirl', manager: $manager);
        $this->createCategory(name: 'chemisesYoungBoy', manager: $manager);
        $this->createCategory(name: 'chemisesBoy', manager: $manager);
        $this->createCategory(name: 'pantalonsYoungBoy', manager: $manager);
        $this->createCategory(name: 'pantalonsBoy', manager: $manager);
        $this->createCategory(name: 'pantalonsYoungGirl', manager: $manager);
        $this->createCategory(name: 'pantalonsGirl', manager: $manager);
        $this->createCategory(name: 'jupesYoungGirl', manager: $manager);
        $this->createCategory(name: 'jupesGirl', manager: $manager);
        $this->createCategory(name: 'accessoires', manager: $manager);

        $manager->flush();
    }

    // Méthode simplifiée sans gestion de catégories parentales
    public function createCategory(string $name, ObjectManager $manager): void
    {
        $category = new Categories();

        $category->setName($name)
            ->setSlug($this->slugger->slug($category->getName())->lower());

        $manager->persist($category);
    }
}
