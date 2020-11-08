<?php

namespace App\Form;

use App\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'attr' => [
                    'class'=> 'w-1/2 ml-1 rounded-md border-blue-700 border-solid border-2 ',
                    ]
            ])
            ->add('Ajouter', SubmitType::class,[
                'attr' => [
                    'class'=> 'py-2 px-1 rounded-md bg-blue-700 border-solid border-2 text-white ',
                    ]
            ])
        ;
    }

     

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
