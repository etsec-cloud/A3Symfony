<?php

namespace App\Form;

use App\Entity\Tournois;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TournoisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class'=> 'w-1/5 ml-1 rounded-md border-blue-700 border-solid border-2 ',
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class'=> 'w-1/5 ml-1 rounded-md border-blue-700 border-solid border-2 ',
                ]
            ])
            ->add('jeu', TextType::class, [
                'attr' => [
                    'class'=> 'w-1/5 ml-1 rounded-md border-blue-700 border-solid border-2 ',
                ]
            ])
            ->add('date', DateTimeType::class)
            ->add('dateFin', DateTimeType::class)
            ->add('cashPrice', NumberType::class, [
                'attr' => [
                    'class'=> 'w-1/5 ml-1 rounded-md border-blue-700 border-solid border-2 ',
                ]
            ])
            ->add('ageMin', NumberType::class, [
                'attr' => [
                    'class'=> 'w-1/5 ml-1 rounded-md border-blue-700 border-solid border-2 ',
                ]
            ])
            ->add('Ajout', SubmitType::class, [
                'attr' => [
                    'class'=> 'py-2 px-1 rounded-md bg-blue-700 border-solid border-2 text-white ml-2 mt-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tournois::class,
        ]);
    }
}
