<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++)
        {
            $article = new Article; // pour pouvoir créer des articles et les insérer en BDD, nous devons instancier la classe/Entité Article qui permet de renseigner les titres, cntenu, image et date de l'article // On fait appel à tous les setteurs de l objet $article pour ajouter un titre, une image, une date à nos articles              

            $article->setTitle("Titre de l'article n° $i")
                    ->setContent("<P>Contenu de l'article n°$i</p>")
                    ->setImage("https://picsum.photos/200")
                    ->setCreatedAt(new \DateTime());
                  
            $manager->persist($article);    // La classe ObjectManager est une classe prédéfinie en Symfony qui permet de manipuler les lignes de la BDD (INSERT, UPDATE, DELETE) // persist() est une méthode issue de la classe ObjectManager qui permet de préparer les insertions et de les garder en mém
        }

        $manager->flush();
    }
}
