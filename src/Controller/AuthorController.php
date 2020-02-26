<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author", name="author.")
 * @IsGranted("ROLE_AUTHOR")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('blog/author/index.html.twig');
    }

    /**
     * @Route("/new", name="post_new")
     */
    public function new(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $img_file = $form->get('img_path')->getData();

            if ($img_file) {
                $original_filename = pathinfo($img_file->getClientOriginalName(), PATHINFO_FILENAME);
                $safe_filename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $original_filename);
                $new_filename = $safe_filename . '-' . uniqid() . '.' . $img_file->guessExtension();

                try {
                    $img_file->move($this->getParameter('post_img'), $new_filename);
                } catch (FileException $e){

                }
            }
        }

        return $this->render('blog/author/new.html.twig', [
            'form_post' => $form->createView(),
        ]);
    }
}
