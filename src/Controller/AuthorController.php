<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
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
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['author' => $this->getUser()], ['id' => 'DESC']);

        return $this->render('blog/author/index.html.twig', [
            'posts' => $posts,
        ]);
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
            $img_file = $form->get('img_path')->getData();

            if ($img_file) {
                $original_filename = pathinfo($img_file->getClientOriginalName(), PATHINFO_FILENAME);
                $safe_filename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $original_filename);
                $new_filename = $safe_filename . '-' . uniqid() . '.' . $img_file->guessExtension();

                try {
                    $img_file->move($this->getParameter('post_img'), $new_filename);
                } catch (FileException $e){

                }

                $post->setImgPath($new_filename);
            }

            $post->setTitle($form->get('title')->getData());
            $post->setContent($form->get('content')->getData());
            $post->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('author.index');
        }

        return $this->render('blog/author/new.html.twig', [
            'form_post' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show")
     */
    public function show(Post $post)
    {

    }

    /**
     * @Route("/edit/{id}", name="post_edit")
     */
    public function edit(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('author.post_edit', ['id' => $post->getId()]);
        }

        return $this->render('blog/author/edit.html.twig', [
            'form_post' => $form->createView(),
            'post' => $post,
        ]);
    }

    /**
     * @Route("/remove/{id}", name="post_delete")
     */
    public function delete(Request $request, Post $post)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('author.index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('author.index');
    }
}
