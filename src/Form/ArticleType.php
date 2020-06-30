<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
<<<<<<< HEAD
            ->add('category', EntityType::class, [ // we are adding a new field here to select a category on adding or modifying an Article
                'class' => Category::class, 
=======
            ->add('category', EntityType::class, [ // creating a new field Category on adding & modifying an Article.
                'class' => Category::class,
>>>>>>> b4b04c116d82e89d213b6680c20d85586fc4f2fd
                'choice_label' => 'title'
            ])
            ->add('content')
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
