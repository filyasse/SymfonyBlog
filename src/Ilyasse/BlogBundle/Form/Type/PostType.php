<?php

namespace Ilyasse\BlogBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',     TextType::class)
            ->add('content',   CKEditorType::class)
            ->add('imageFile', VichImageType::class)
            ->add('categories', EntityType::class, array(
                'class' => 'IlyasseBlogBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,
            ))
            ->add('save',      SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'ilyasse_blog_bundle_post_type';
    }
}
