<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\PostMeta;
use App\Entity\Tag;
use App\Entity\User;
use App\Form\PostType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        //dump($request);die;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post_meta = new PostMeta();
            $img_file = $form->get('img_path')->getData();

            if ($img_file) {
                $filename = $fileUploader->upload($img_file);
                $post->setImgPath($filename);
            }

            $post->setAuthor($this->getUser())->setMeta($post_meta);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post_meta);
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('author.index');
        }

        return $this->render('blog/author/new.html.twig', [
            'form_post' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="post_edit")
     * @param Request $request
     * @param Post $post
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Post $post, FileUploader $fileUploader)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img_file = $form->get('img_path')->getData();

            if ($img_file) {
                $filesystem = new Filesystem();
                $filesystem_img = $this->getParameter('post_img');

                $file = $filesystem_img . $post->getImgPath();

                if ($filesystem->exists($file)) {
                    $filesystem->remove($file);
                }

                $filename = $fileUploader->upload($img_file);
                $post->setImgPath($filename);
            }

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
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, Post $post)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('author.index');
        }

        $post_entity = new Post();

        if ($post->getImgPath() !== $post_entity->getImgPath()) {
            $filesystem = new Filesystem();
            $filesystem_img = $this->getParameter('post_img');
            $file = $filesystem_img . $post->getImgPath();

            if ($filesystem->exists($file)) {
                $filesystem->remove($file);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('author.index');
    }
}
