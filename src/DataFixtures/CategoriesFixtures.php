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
        // Création des catégories parentes
        $profilesCategory = $this->createCategory(name: 'Profiles', manager: $manager, parent: null, categoryOrder: 0);
        // Création des catégories enfants
        $this->createCategory(name: 'Bébé Fille', manager: $manager, parent: $profilesCategory, categoryOrder: 1);
        $this->createCategory(name: 'Fille', manager: $manager, parent: $profilesCategory, categoryOrder: 2);
        $this->createCategory(name: 'Bébé Garçon', manager: $manager, parent: $profilesCategory, categoryOrder: 3);
        $this->createCategory(name: 'Garçon', manager: $manager, parent: $profilesCategory, categoryOrder: 4);

        // Création des catégories parentes
        $typesCategory = $this->createCategory(name: 'Types', manager: $manager, parent: null, categoryOrder: 5);
        // Création des catégories enfants
        $this->createCategory(name: 'T-Shirts', manager: $manager, parent: $typesCategory, categoryOrder: 6);
        $this->createCategory(name: 'Robes', manager: $manager, parent: $typesCategory, categoryOrder: 7);
        $this->createCategory(name: 'Chemises', manager: $manager, parent: $typesCategory, categoryOrder: 8);
        $this->createCategory(name: 'Pantalons', manager: $manager, parent: $typesCategory, categoryOrder: 9);
        $this->createCategory(name: 'Jupes', manager: $manager, parent: $typesCategory, categoryOrder: 10);
        $this->createCategory(name: 'Shorts', manager: $manager, parent: $typesCategory, categoryOrder: 11);

        $manager->flush();
    }

    // Ajoutez $parent comme paramètre de la méthode createCategory
    public function createCategory(string $name, ObjectManager $manager, int $categoryOrder, ?Categories $parent = null)
    {
        $category = new Categories();

        $category->setName($name)
            ->setSlug($this->slugger->slug($category->getName())->lower())
            ->setCategoryOrder($categoryOrder);

        if ($parent) {
            $category->setParent($parent);
        }

        $manager->persist($category);

        return $category;
    }
}
