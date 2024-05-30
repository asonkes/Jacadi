<?php

namespace App\DataFixtures;

use App\Entity\Products;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Categories; // N'oubliez pas d'importer la classe Categories

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Categories::class)->findAll();

        // Produits bébé fille
        $this->createProduct(name: 'Robe verte légère', price: 27.00, stock: 4, image: 'TY30102_54_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'T-shirt blanc', price: 12.00, stock: 4, image: 'slide-mobile (1).jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'T-Shirt Bleu', price: 15.00, stock: 4, image: 'TY12021-42_TY22011-45_1024x.png', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Robe rouge été', price: 26.00, stock: 4, image: 'TY30022-35_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Pull rose', price: 22.00, stock: 4, image: 'TY10012-13_TY27022-31_TY18012-32_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Robe colorée rose', price: 26.00, stock: 4, image: 'adorable-petite-fille-bouquet-fleurs-sauvages_1157-1635.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Pull rose', price: 12.00, stock: 4, image: 'TY37002-70_1_40517fb8-4d72-45eb-bc6a-d7f603e94d75_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Robe jaune et blanche', price: 27.00, stock: 4, image: 'petite-fille-beaux-longs-cheveux-dans-robe-jaune-joue-ete_1157-14056.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'T-Shirt blanc et bleu', price: 18.00, stock: 4, image: 'TY12012-42_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Short bleu', price: 15.00, stock: 4, image: 'TY18012-01_TY26012-45_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Robe blanche', price: 24.00, stock: 4, image: 'TY30042-01_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Jupe rose et blanche', price: 22.00, stock: 4, image: 'TY10002-01_TY27002-01_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Robe blanche avec ceinture blau', price: 28.00, stock: 4, image: 'belle-famille-dans-foret_1328-727.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'T-shirt Blanc et bleu', price: 20.00, stock: 4, image: 'TY12042-01_TY26042-45_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);
        $this->createProduct(name: 'Robe rose clair', price: 26.00, stock: 4, image: 'TY30102-30_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);

        $this->createProduct(name: 'Robe rose princesse', price: 32.00, stock: 4, image: 'TY30262-35_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[1]);

        // Produits fille
        $this->createProduct(name: 'Robe moltonée', price: 28.00, stock: 4, image: 'TW10011-01_TW22011-45_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'jupe colorée', price: 20.00, stock: 4, image: 'jupe-de-ceremonie-a-fleurs-fille.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Robe de cérémonie avec fleur', price: 32.00, stock: 4, image: 'PUSH_LAYER_VERTICALE_b185c97f-8e6b-4843-b242-8f2b239e43b3_10.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Jean vert', price: 25.00, stock: 4, image: 'TY10012-13_TY22022-54_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'T-Shirt Rose', price: 15.00, stock: 4, image: 'TY10012-30_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Pull bleu foncé crocheté', price: 28.00, stock: 4, image: 'TY18042-04_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Robe Rouge et blanche', price: 35.00, stock: 4, image: 'TY30082-33_4_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'T-Shirt Rouge', price: 18.00, stock: 4, image: 'TY30042-35_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Jupe avec fleur en imprimé', price: 35.00, stock: 4, image: 'TY27012-04_TY10002-01_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Robe de cérémonie bleue', price: 38.00, stock: 4, image: 'TY30132-42_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'T-Shirt avec imprimé', price: 18.00, stock: 4, image: 'TY12002-01_TY22012-04_1.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'T-Shirt coloré', price: 20.00, stock: 4, image: 'TY12012-31_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Robe Bleue Crochetée', price: 35.00, stock: 4, image: 'TC_CO_CAPSULE_1936_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Jeans Bleu', price: 25.00, stock: 4, image: 'TY10022-30_TY22012-46_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Pull Bleu avec imprimé', price: 25.00, stock: 4, image: 'push-mis-en-avant-fille-mobile (3).jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Robe été', price: 32.00, stock: 4, image: 'TY30152-13_TY90002-61_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Robe de cérémonie rose', price: 35.00, stock: 4, image: 'TY30132-35_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Pull Bleu foncé avec col', price: 24.00, stock: 4, image: 'TY15012-04_TY22042-01_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'Pull blanc crocheté', price: 28.00, stock: 4, image: 'TY18042-01_TY22012-46_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);
        $this->createProduct(name: 'T-Sirt avec coeur', price: 15.00, stock: 4, image: 'TY22042-01_TY10022-01_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[2]);

        // Produits bébé garçon
        $this->createProduct(name: 'T-shirt Rayé Bleu', price: 15.00, stock: 4, image: 'TW12071-13_TW22031-78_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Chemise rayée blanche', price: 18.00, stock: 4, image: 'pexels-photo-15466102.jpeg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Chemise colorée', price: 21.00, stock: 4, image: 'pexels-photo-1427288.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Pull gris', price: 23.00, stock: 4, image: 'kid-coup-moyen-assis-cloture_23-2148770943.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'T-shirt blanc', price: 12.00, stock: 4, image: 'concept-art-technologie-passe-temps-enfance_343059-3581.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Pull brun crocheté', price: 25.00, stock: 4, image: 'enfant-mignon-jouant-plage_23-2150924975.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'T-Shirt bleu', price: 14.00, stock: 4, image: 'pantalon-bebe-garcon.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'T-Shirt blanc avec tracteur', price: 16.00, stock: 4, image: 'TY10051-77_TY26101-77_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Short bleu foncé', price: 15.00, stock: 4, image: 'TY11041-43_TY26131-04_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Chemise blanche été', price: 22.00, stock: 4, image: 'TY12101-01_TY26091-44_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Pull vert clair', price: 28.00, stock: 4, image: 'TY15021-52_TY26101-01_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Pantalon brun avec poches', price: 32.00, stock: 4, image: 'TY15031-43_TY22111-62_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Short vert', price: 15.00, stock: 4, image: 'TY12111-01_TY26091-53_3_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'Pantalon vert clair', price: 25.00, stock: 4, image: 'TY11033-53_TY26073-52_TY10051-52_TY22081-52_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);
        $this->createProduct(name: 'T-Shirt blanc et bleu', price: 16.00, stock: 4, image: 'TY26121-44_TY10051-43_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[3]);

        // Produits garçon
        $this->createProduct(name: 'Chemise Bleu foncé', price: 20.00, stock: 4, image: 'pexels-photo-4563009.jpeg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Short jaune', price: 15.00, stock: 4, image: 'TY38013-70_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'T-Shirt Bleu', price: 18.00, stock: 4, image: 'TW10023-43_TW26023-52_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'T-shirt blanc', price: 12.00, stock: 4, image: 'TY11013-01_1024x.png', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Short blanc et bleu clair', price: 15.00, stock: 4, image: 'TY38041-43_3_e4eae1b2-b044-4ab7-9b3b-e619589ddab3_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'T-Sirt blanc et vert', price: 12.00, stock: 4, image: 'TY10013-01_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Pull orangé', price: 28.00, stock: 4, image: 'gens-qui-ramassent-nourriture-dans-foret_23-2150167845.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'T-Shirt Camion', price: 15.00, stock: 4, image: 'TY22003-77_TY10023-77_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Chemise rayée rouge et noire', price: 22.00, stock: 4, image: 'jeune-garcon-tenant-camera-exterieur-parents_23-2148647740.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Pull bleu crocheté', price: 28.00, stock: 4, image: 'TY18043-04_TY12063-45_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 't-Shirt vert clair', price: 12.00, stock: 4, image: 'TY10003-52_TY26013-01_2_20b4c693-0e49-4a01-902f-21bdd89c84bc.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Short bleu foncé', price: 18.00, stock: 4, image: 'TY18003-17_TY12023-01_TY26003-04_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Chemise bleu effet jeans', price: 28.00, stock: 4, image: 'TY15023-43_TY12063-45_TY22003-01_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Short vert', price: 22.00, stock: 4, image: 'TY17013-53_TY26013-52_3_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Short vert', price: 16.00, stock: 4, image: 'TY12013-01_TY26003-53_3_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Pull vert', price: 28.00, stock: 4, image: 'TY12003-53_TY26013-52_TY18003-53_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Pull gris avec imprimé', price: 25.00, stock: 4, image: 'TY18013-21_2_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'T-Shirt bleu et blanc', price: 16.00, stock: 4, image: 'TY11023-43_1_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'T-Shirt nature', price: 14.00, stock: 4, image: 'TY10023-52_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);
        $this->createProduct(name: 'Chemise blanche été', price: 24.00, stock: 4, image: 'TY12033-01_1024x.jpg', createdAt: new DateTimeImmutable('2024-05-23'), manager: $manager, category: $categories[4]);

        $manager->flush();
    }

    public function createProduct(string $name, float $price, int $stock, string $image, Categories $category, ObjectManager $manager, ?DateTimeImmutable $createdAt = null)
    {
        $product = new Products();

        $createdAt = $createdAt ?? new DateTimeImmutable();

        $product->setName($name)
            ->setSlug($this->slugger->slug($product->getName())->lower())
            ->setPrice($price)
            ->setStock($stock)
            ->setImage($image)
            ->setCreatedAt($createdAt)
            ->setCategories($category);

        $manager->persist($product);

        return $product;
    }
}
