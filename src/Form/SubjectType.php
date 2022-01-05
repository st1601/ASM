<?php

namespace App\Form;

use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('subjectID',TextType::class,[
            'label' => 'subjectID',
            'required' =>true,
            'attr' =>[
                'minlength' =>1,
                'maxlength' => 30
            ]
        ])
        ->add('name',TextType::class,[
            'label' => 'Subject Name',
            'required' =>true,
            'attr' =>[
                'minlength' =>3,
                'maxlength' => 30
            ]
        ])
        ->add('schedule', DateType::class,[
            'label' => 'Time start subject',
            'required' => true,
            'widget' => 'single_text'
        ])
        
        ->add('material',FileType::class,
        [
            'label' => 'material',
            'data_class' => null,
            'required' => is_null($builder->getData()->getMaterial())
        ])

        // ->add('semester')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
