<?php

namespace App\Form;

use App\Entity\Subject;
use App\Entity\Semester;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class SemesterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'label' => ' Semester name',
            'required' => true,
            'attr' => ['minlength' => 3,
                        'maxlength' => 30]
        ])
        ->add('timeStart',DateType::class,
        
        [
            'label' => 'Time start semester',
            'required' => true,
            'widget' => 'single_text'
        ])
        ->add('timeEnd', DateType::class,
        [
            'label' => 'Time ending semester',
            'required' => true,
            'widget' => 'single_text'
        ])
        ->add('tuition',MoneyType::class,[
            'label' => 'Tuition',
            'required' => true,
            'currency' => 'USD'

        ])
    ->add('subjects', EntityType::class,
            [
                'label' => 'subject',
                'required' => true,
                'class' => Subject::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Semester::class,
        ]);
    }
}
