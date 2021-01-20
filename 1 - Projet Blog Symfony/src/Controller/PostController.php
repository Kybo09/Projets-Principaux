<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
     /**
     * @Route("/blog/admin", name="admin")
     */
    public function homeAdmin(){
        return $this->render('blog/admin/homeAdmin.html.twig', [

        ]);
    }

    /**
     * @Route("/blog/admin/posts", name="listPost")
     */
    public function show(){
        $postRepo = $this->getDoctrine()->getRepository(Post::class);
        $listPost = $postRepo->findBy(array(), array('publishedAt' => 'DESC'));

        return $this->render('blog/admin/listePosts.html.twig', [
            'listPost' => $listPost,
        ]);
    }

    /**
     * @Route("/blog/admin/posts/edit/{idPost}", name="editPost")
     */
    public function editPost(Request $request, $idPost): Response{

        $postRepo = $this->getDoctrine()->getRepository(Post::class);
        $postEdit = $postRepo->find($idPost);

        $form = $this->createForm(PostType::class, $postEdit);

        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postEdit);
            $entityManager->flush();
            return $this->redirectToRoute('listPost');
        }

        return $this->render('blog/admin/editPost.html.twig', [
            'formView' => $form->createView(),
            'post' => $postEdit,
        ]);

    }

    /**
     * @Route("/blog/admin/posts/add", name="addPost")
     */
    public function addPost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $post->setCreatedAt(new \DateTime('NOW'));
            $post->setUpdatedAt(new \DateTime('NOW'));
            $post->setSlug(self::slugify($post->getTitle()));
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('showPost', ['slug' => $post->getSlug()]);
        }


        return $this->render('blog/admin/addPost.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/posts/{slug}", name="showPost")
     */
    public function showPost($slug, Request $request): Response
    {
        $comment = new Comment();

        $postRepo = $this->getDoctrine()->getRepository(Post::class);
        $commentRepo = $this->getDoctrine()->getRepository(Comment::class);

        $post = $postRepo->findBy(array('slug'=> $slug));

        $listComment = $commentRepo->getValidCommentByIdPost($post[0]->getId());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setCreatedAt(new \DateTime('NOW'));
            $comment->setValid(0);
            $comment->setPost($post[0]);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('showPost', ['slug' => $slug]);
        }

        return $this->render('blog/admin/post.html.twig', [
            'post' => $post,
            'listCom' => $listComment,
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("blog/admin/posts/remove/{idpost}", name="removePost")
     */
    public function removeComments($idpost): Response
    {
        $postRepo = $this->getDoctrine()->getRepository(Post::class);
        $post = $postRepo->find($idpost);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('listPost');

    }


    public static function slugify($text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * @Route("/blog/{page}", name="home")
     *
     */
    public function home(int $page = 1): Response
    {
        $oldpage = $page;
        if($page < 1){
            $page = 1;
        }
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->getPublishedPost($page*5, 5);
        $nbPages = ceil(count($repo->getPublishedPost())/5);

        return $this->render('blog/home.html.twig', [
            'listPost' => $posts,
            'pages' => $nbPages,
            'page' => $oldpage
        ]);
    }

    /**
     * @Route("/", name="start")
     */
    public function redirectToBlog(){
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("blog/category/{idcat}", name="postByCat")
     */
    public function getPostByCategory($idcat){
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $listPost= $repo->getPostByCategory($idcat);

        $catrepo = $this->getDoctrine()->getRepository(Category::class);
        $catinfo = $catrepo->find($idcat);

        return $this->render('blog/postCategory.html.twig', [
            'listPost' => $listPost,
            'cat' => $catinfo
        ]);
    }


}
