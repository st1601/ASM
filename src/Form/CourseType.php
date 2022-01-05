<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add(
            'name',
            TextType::class,
            [
                'label' => 'Course Name',
                'required' => true
            ]
        )


        ->add(
            'grade',
            TextType::class,
            [
                'label' => 'Grade',
                'required' => true,
            ]
        )
        // ->add('teacher', EntityType::class,
        //     [
        //         'label' => 'Teacher(s)',
        //         'required' => true,
        //         'class' => Teacher::class,
        //         'choice_label' => 'name',
        //         'multiple' => true,
        //         'expanded' => true
        //     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
