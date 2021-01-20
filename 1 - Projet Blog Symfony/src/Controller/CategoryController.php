<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use const http\Client\Curl\Versions\CURL;

class CategoryController extends AbstractController
{
    /**
     * @Route("blog/admin/categories", name="showCategory")
     */
    public function showCategory(): Response
    {
        $postRepo = $this->getDoctrine()->getRepository(Category::class);
        $listCat = $postRepo->findBy(array(), array('name' => 'ASC'));

        return $this->render('blog/admin/listeCategories.html.twig', [
            'listCat' => $listCat,
        ]);
    }

    /**
     * @Route("/blog/admin/category/add", name="addCategory")
     */
    public function addPost(Request $request): Response
    {
        $cat = new Category();
        $form = $this->createForm(CategoryType::class, $cat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();
            return $this->redirectToRoute('showCategory');
        }

        return $this->render('blog/admin/addCategory.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/admin/category/edit/{idCat}", name="editCategory")
     */
    public function editCategory(Request $request, $idCat): Response{

        $catRepo = $this->getDoctrine()->getRepository(Category::class);
        $catEdit = $catRepo->find($idCat);

        $form = $this->createForm(CategoryType::class, $catEdit);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catEdit);
            $entityManager->flush();
            return $this->redirectToRoute('showCategory');
        }

        return $this->render('blog/admin/editCategory.html.twig', [
            'formView' => $form->createView(),
            'cat' => $catEdit,
        ]);

    }

    /**
     * @Route("blog/admin/category/remove/{idcat}", name="removeCategory")
     */
    public function removeComments($idcat): Response
    {
        $catRepo = $this->getDoctrine()->getRepository(Category::class);
        $cat = $catRepo->find($idcat);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cat);
        $entityManager->flush();

        return $this->redirectToRoute('showCategory');

    }

    /**
     * @Route("blog/category/catwithpost", name="catWithPost")
     */
    public function getCategoryWithPost(){
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $listCat = $repo->getCategoryWithPost();

        return $this->render('blog/_listeCategorie.html.twig', [
            'listCat' => $listCat
        ]);
    }


}
