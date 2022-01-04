<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'label' => 'Room name',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 30
            ]
        ])
        ->add('teacher', TextType::class,
        [
            'label' => 'Teacher name',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 30
            ]
        ])
        ->add('address', TextType::class,
        [
            'label' => 'Room address',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 50
            ]
        ])
        ->add('description', TextType::class,
        [
            'label' => 'Room description',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 50
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
