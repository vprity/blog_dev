<?php


namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getCategories()
    {
        return $this->doctrine->getRepository(Category::class)->findByAllCategories();
    }
}