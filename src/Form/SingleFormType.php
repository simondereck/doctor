<?php

namespace App\Form;

use App\Entity\Single;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SingleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('series',TextType::class,[
                'required'   => false,
            ])
            ->add('subSeries',TextType::class,[
                'required'   => false,
                'empty_data' => "",

            ])
            ->add('category',TextType::class,[
                'required'   => false,
            ])
            ->add('cc',TextType::class,[
                'required'   => false,
            ])
            ->add('tid',TextType::class,[
                'required'   => false,
            ])
            ->add('declare_no',TextType::class,[
                'required'   => false,
            ])
            ->add('sku',TextType::class,[
                'required'   => false,
            ])
            ->add('ean',TextType::class,[
                'required'   => false,
            ])
            ->add('lot',TextType::class,[
                'required'   => false,
            ])
            ->add('name',TextType::class,[
                'required'   => false,
            ])
            ->add('latin',TextType::class,[
                'required'   => false,
            ])
            ->add('pinyin',TextType::class,[
                'required'   => false,
            ])
            ->add('etiquette',TextType::class,[
                'required'   => false,
            ])
            ->add('label',TextType::class,[
                'required'   => false,
            ])
            ->add('use_as',TextType::class,[
                'required'   => false,
            ])
            ->add('shop',TextType::class,[
                'required'   => false,
            ])
            ->add('description',TextType::class,[
                'required'   => false,
            ])
            ->add('latin_real')
            ->add('submit',SubmitType::class,[
                "attr"=>["class"=>"btn btn-success"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Single::class,
        ]);
    }
}
