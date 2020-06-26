<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {

        /*  Un des principes de principe de base de Symfony est l'injection de dépendances.
            Par exemple, ici dans le cas de la méthode index(), cette a besoin de la classe ArticleRepository pour fonctionner correctement, c'est à dire que la méthode index() dépend de la classe ArticleRepository
            Donc ici on injecte une dépendance en argument de la méthode index(), on impose un objet issu de la classe ArticleRepository
            Du coup plus besoin de faire appel à Doctrine (getDoctrine())
            $repo est un objet issu de la classe ArticleRepository et nous avons accès à toute les méthodes issues de cette classe
            Les méthodes sont moins chargé et c'est plus simple d'utilisation 

        */

        //$repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll(); //doctrine recuperates the database from article.php from entity whoch here represents the "$articles" and then from repository "ArticleRepository" from repository which represents the "$repo".

        dump($articles); 


        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles // called in Line 11in index.html.twig

        ]);
    }
    
   
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue sur le blog Symfony',
            'age' => 25
        ]);
    }



     /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function  form(Article $article = null, Request $request, EntityManagerInterface $manager) // Request is a predefined Symfony Class == when the form is filled up, this particular class 'Request' collects the inputs from form and sends to the DB!
    //Method 'Create' depends on the Interface 'EntityManagerInterface', without this interface the method 'Create' cannot exceute on its own!
    {
        dump($request);

        // if($request->request->count()>0)
        // {
        //     $article = new Article;

        //     $article -> setTitle($request->request->get('title'))
        //              -> setContent($request->request->get('content'))
        //              -> setImage($request->request->get('image'))
        //              -> setCreatedAt(new \DateTime());

        //     $manager->persist($article);
        //     $manager->flush();

        //     dump($article);

        //     return $this->redirectToRoute('blog_show',[
        //         'id' => $article->getId()
        //        ]);

        // }

        /*
            ->add('title', TextType::class, [
                         'attr'=> [
                                                      
                            'placeholder' => "Saisir le titre de l'article",
                            'class' => "col-md-6 mx-auto"
                            ]
                     ])
                    $article->setTitle("Titre à la con")
                            ->setContent("Contenu à la con");

        */


        if(!$article)
        {
            $article = new Article;
        }
        $form = $this->createForm(ArticleType::class, $article);
              
        // $form = $this->createFormBuilder($article)  /// Predefined Symfony Method 'createFormBuilder' to create a form
        //              ->add('title')
        //              ->add('content')
        //              ->add('image')
        //              ->getForm();

        $form->handleRequest($request); // it collects the information from the object and sends it to the particular objetc, ex: collects and image and sends it to to image DB

        if($form->isSubmitted() && $form->isValid())
        {

            if(!$article->getId())
            {

               $article->setCreatedAt(new \DateTime);

            }
            $manager->persist($article);
            $manager->flush(); 

            dump($article);

            return $this->redirectToRoute('blog_show',[
                    'id' => $article->getId()
                ]);
        }


        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(), /// Predefined Symfony Method 'createView' which follows the above method 'createFormBuilder'
            'editMode' => $article->getId() !=null    
        ]);

    }

    

    /**
     *  @Route("/blog/{id}", name="blog_show")
     */
    public function show(ArticleRepository $repo, $id)
    {

        /* Pour selectionneer 1 article en BDD, c'est à dire voir le détail d'1 article, nous utilisons le principe de route paramétrée ("/blog/{id}"), notre route attends un paramètre de type {id}, donc l'id d'1 article qui est stocké en BDD Lorsque nous tranmettons dans l'URL une route par exempl "/blog/9", on envoi un id connu dans l'URL, Symfony va automatiquement recupéré ce paramètre pour le transmettre en argument de la méthode show($id)  Cela veut dire que nous avons accès à l'{id} à l'intérieur de la méthode show() Le but est de selectionner les données en BDD de l'{id} récupéré en paramètre Nous avons besoin pour cela de la classe ArticleRepository afin de pouvoir selectionner en BDD 
        La méthode find() est issue de la classe ArticleRepository et permet de selectionner des données en BDD avec un argument de type {id} 
        DOCTRINE fait ensuite tout le travail pour nous, c'est à dire qu'elle recupère la requete de selection pour l'executer en BDD et elle retourne le resultat au controller

        $rep est un objet issu de la classe ArticleRepository, cette contient des methodes predefibes par Symfony permettant de selectionner des données en BDD (find(), findBy(), findOneBy(), findAll())
        */


        //$repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);

        dump($article);

        return $this->render('blog/show.html.twig', [  //Method "Render" has 2 parameters => "'blog/show.html.twig' (=> template Html) & 'article'
            'article' => $article // Called in Line 8 of Show.html.twig
        ]);
    }

    

}
