<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile.")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="index")
     */
    public function index()
    {

    }
}
