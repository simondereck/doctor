<?php

namespace App\Form;

use App\Entity\Single;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SingleUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('series')
            ->add('subSeries')
            ->add('category')
            ->add('cc')
            ->add('tid')
            ->add('declare_no')
            ->add('sku')
            ->add('ean')
            ->add('lot')
            ->add('name')
            ->add('latin')
            ->add('pinyin')
            ->add('etiquette')
            ->add('label')
            ->add('use_as')
            ->add('shop')
            ->add('description')
            ->add('utime')
            ->add('ctime')
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
