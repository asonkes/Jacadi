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
        $profilesCategory = $this->createCategory('Profiles', $manager, 0, null);
        // Création des catégories enfants
        $this->createCategory('Bébé Fille', $manager, 1, $profilesCategory, 'category-bebe-fille');
        $this->createCategory('Fille', $manager, 2, $profilesCategory, 'category-fille');
        $this->createCategory('Bébé Garçon', $manager, 3, $profilesCategory, 'category-bebe-garcon');
        $this->createCategory('Garçon', $manager, 4, $profilesCategory, 'category-garcon');

        // Création des catégories parentes
        $typesCategory = $this->createCategory('Types', $manager, 5, null);
        // Création des catégories enfants
        $this->createCategory('T-Shirts', $manager, 6, $typesCategory, 'category-t-shirts');
        $this->createCategory('Robes', $manager, 7, $typesCategory, 'category-robes');
        $this->createCategory('Chemises', $manager, 8, $typesCategory, 'category-chemises');
        $this->createCategory('Pantalons', $manager, 9, $typesCategory, 'category-pantalons');
        $this->createCategory('Jupes', $manager, 10, $typesCategory, 'category-jupes');
        $this->createCategory('Shorts', $manager, 11, $typesCategory, 'category-shorts');

        $manager->flush();
    }

    public function createCategory(string $name, ObjectManager $manager, int $categoryOrder, ?Categories $parent = null, string $referenceName = null): Categories
    {
        $category = new Categories();

        $category->setName($name)
            ->setSlug($this->slugger->slug($category->getName())->lower())
            ->setCategoryOrder($categoryOrder);

        if ($parent) {
            $category->setParent($parent);
        }

        $manager->persist($category);

        if ($referenceName) {
            $this->addReference($referenceName, $category);
        }

        return $category;
    }
}
