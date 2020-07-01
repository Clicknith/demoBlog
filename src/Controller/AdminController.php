<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/articles", name="admin_articles")
     */
     public function adminArticles(ArticleRepository $repo)
     {

        $em = $this->getDoctrine()->getManager();

        $colonnes =$em->getClassMetaData(Article::class)->getFieldNames();
        
        $articles = $repo->findAll(); 

        dump($articles);
        dump($colonnes);

        return $this->render('admin/admin_articles.html.twig',[
            'articles' => $articles,
            'colonnes' => $colonnes
        ]);
     }

     /**
      * @Route("/admin/{id}/edit-article", name="admin_edit_article")
      */
      public function editArticle(Article $article)
      {
        dump ($article);

        $form = $this->createForm(ArticleType::class, $article);
        
        return $this->render('admin/edit_article.html.twig',[
            'formEdit' => $form->createView()
        ]);
      }

}
