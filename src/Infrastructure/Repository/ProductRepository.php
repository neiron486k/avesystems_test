<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product, bool $flush = true): Product
    {
        $manager = $this->getEntityManager();
        $manager->persist($product);

        if ($flush) {
            $manager->flush();
        }

        return $product;
    }
}