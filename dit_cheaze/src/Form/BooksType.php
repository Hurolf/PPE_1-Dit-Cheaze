<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class BooksType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titles', TextType::class,[
                'label'=>'Titre:'
            ])
            ->add('Descriptions', TextType::class, [
                'label'=>'Descriptions:'
            ])
            ->add('BackImage', FileType::class, [
                'label'=>'Image de présentation:',
                'required'=>true
            ])
            ->add('CountImages', FileType::class,[
                'label'=>'Selectionner les images:',
                'mapped'=>false,
                'multiple'=>true,
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }


}
