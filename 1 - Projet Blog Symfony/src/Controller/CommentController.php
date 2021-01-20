<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("blog/admin/comments", name="showComments")
     */
    public function showComments(): Response
    {
        $postRepo = $this->getDoctrine()->getRepository(Comment::class);
        $listComment = $postRepo->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('blog/admin/listeComments.html.twig', [
            'listComment' => $listComment,
        ]);
    }


    /**
     * @Route("blog/admin/comments/moderation/approve/{idcom}", name="approveComments")
     */
    public function approveComments($idcom): Response
    {
        $postRepo = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $postRepo->find($idcom);

        $comment->setValid(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('showComments');

    }

    /**
     * @Route("blog/admin/comments/moderation/remove/{idcom}", name="removeComments")
     */
    public function removeComments($idcom): Response
    {
        $comRepo = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $comRepo->find($idcom);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('showComments');

    }

    /**
     * @Route("/blog/lastcomment/", name="lastComment")
     *
     */
    public function lastComment(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $repo->getLastComment(5);


        return $this->render('blog/_lastComments.html.twig', [
            'listComments' => $comments
        ]);
    }

    /**
     * @Route("blog/admin/comments/moderation", name="commentModeration")
     */
    public function showNotValidComments(): Response
    {
        $postRepo = $this->getDoctrine()->getRepository(Comment::class);
        $listComment = $postRepo->findBy(array('valid' => 0), array('createdAt' => 'DESC'));

        return $this->render('blog/admin/commentModeration.html.twig', [
            'listComment' => $listComment,
        ]);
    }


}
