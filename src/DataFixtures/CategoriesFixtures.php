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
        $typesCategory = $this->createCategory(name: 'Types', manager: $manager);
        $this->createCategory(name: 'tShirts', manager: $manager, parent: $typesCategory);
        $this->createCategory(name: 'robes', manager: $manager, parent: $typesCategory);
        $this->createCategory(name: 'chemises', manager: $manager, parent: $typesCategory);
        $this->createCategory(name: 'pantalons', manager: $manager, parent: $typesCategory);
        $this->createCategory(name: 'jupes', manager: $manager, parent: $typesCategory);
        $this->createCategory(name: 'accessoires', manager: $manager, parent: $typesCategory);

        $profilesCategory = $this->createCategory(name: 'Profiles', manager: $manager);
        $this->createCategory(name: '', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'robes', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'chemises', manager: $manager, parent: $profilesCategory);
        $this->createCategory(name: 'pantalons', manager: $manager, parent: $profilesCategory);

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
