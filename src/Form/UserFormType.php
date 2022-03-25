<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('telephone')
            ->add('password')
            ->add('status',ChoiceType::class,[
                "choices"=>[
                    "屏蔽"=>0,
                    "激活"=>1
                ]
            ])
//            ->add('submit',SubmitType::class)

            ->add("submit",SubmitType::class,[
                "attr"=>["class"=>"btn btn-success"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
