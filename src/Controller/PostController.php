<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/{id}", name="show")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Post $post)
    {
        $views = $post->getMeta()->getViews();
        $views++;

        $post->getMeta()->setViews($views);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->render('main/post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
