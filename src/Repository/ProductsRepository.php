<?php

namespace App\Repository;

use App\Entity\Products;
use App\Entity\Categories;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    // On prend en compte la catégorie en paramètre, on passe l'objet de la catégory
    public function findProductsPaginated(int $page, Categories $categories, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];

        $query = $this->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->where('c = :category')
            ->setParameter('category', $categories)
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        // On vérifie que l'on a des données, si pas de données, on retourne le résultat
        if (empty($data)) {
            return $result;
        }

        // On calcule le nombre de pages
        $pages = ceil($paginator->count() / $limit);

        // On remplit le tableau
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;

        return $result;
    }
}
