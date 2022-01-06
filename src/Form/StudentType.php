<?php

namespace App\Form;

use App\Entity\Room;
use DateTimeInterface;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'label' => 'Student name',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 30
            ]
        ])
        ->add('birthday', DateType::class,
        [
            'label' => 'Student birthday',
            'required' => true,
            'widget' => 'single_text'
        ])
        // ->add('present', DateType::class,
        // [
        //     'label' => 'Student present',
        //     'required' => true,
        //     'widget' => 'single_text'
        // ])
        ->add('address', TextType::class,
        [
            'label' => 'Student address',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 50
            ]
        ])
        ->add('mobile', NumberType::class,
        [
            'label' => 'Mobile number',
            'required' => true,
            'attr' => [
                'minlength' => 10,
                'maxlength' => 10
            ]
        ])
            ->add('cover', FileType::class,
            [
                'label' => 'Cover',
                'data_class' => null,
                'required' => is_null ($builder->getData()->getCover())         
            ])
            ->add('room', EntityType::class,
            [
                'label' => 'Room(s)',
                'required' => true,
                'class' => Room::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
