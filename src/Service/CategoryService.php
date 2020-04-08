<?php


namespace App\Service;

use App\Entity\Category;
use Twig\Environment;

class CategoryService
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function navigationCategory()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $this->twig->render('main/layouts/_main-nav.html.twig', [
            'categories' => $categories,
        ]);
    }
}