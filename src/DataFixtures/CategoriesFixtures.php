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
        $profilesCategory = $this->createCategory(name: 'Profiles', manager: $manager);
        // Création des catégories enfants
        $this->createCategory(name: 'Bébé Fille', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'Fille', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'Bébé Garçon', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'Garçon', manager: $manager, parent: $profilesCategory);

        // Création des catégories parentes
        $typesCategory = $this->createCategory(name: 'Types', manager: $manager);
        // Création des catégories enfants
        $this->createCategory(name: 'Bébé Fille', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'Fille', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'Bébé Garçon', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'Garçon', manager: $manager, parent: $profilesCategory);

        $manager->flush();
    }

    // Ajoutez $parent comme paramètre de la méthode createCategory
    public function createCategory(string $name, ObjectManager $manager, ?Categories $parent = null)
    {
        $category = new Categories();

        $category->setName($name)
            ->setSlug($this->slugger->slug($category->getName())->lower());

        if ($parent) {
            $category->setParent($parent);
        }

        $manager->persist($category);

        return $category;
    }
}
