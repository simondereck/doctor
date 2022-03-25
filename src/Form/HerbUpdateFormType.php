<?php

namespace App\Form;

use App\Entity\Herb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HerbUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fid')
            ->add('tid')
            ->add('cmd',TextType::class,["label"=>"detail1",
                'required'   => false,
            ])
            ->add('hmethod',TextType::class,["label"=>"detail2",
                'required'   => false,
            ])
            ->add('category',TextType::class,[
                'required'   => false,
            ])
            ->add('cc',TextType::class,[
                'required'   => false,
            ])
            ->add('series',TextType::class,[
                'required'   => false,
            ])
            ->add('subSeries',TextType::class,[
                'required'   => false,
            ])
            ->add('pinyin',TextType::class,[
                'required'   => false,
            ])
            ->add('latinName',TextType::class,[
                'required'   => false,
            ])
            ->add('name',TextType::class,[
                'required'   => false,
            ])
            ->add('realLatin',TextType::class,[
                'required'   => false,
            ])
            ->add('realPinyin',TextType::class,[
                'required'   => false,
            ])
            ->add('realName',TextType::class,[
                'required'   => false,
            ])
            ->add("membrum",TextType::class,[
                'required'   => false,
            ])
            ->add("membrumSub",TextType::class,[
                'required'   => false,
            ])
            ->add('fp',TextType::class,[
                'required'   => false,
            ])
            ->add('franceName',TextType::class,[
                'required'   => false,
            ])
            ->add("packageFranceName",TextType::class,[
                'required'   => false,
            ])
            ->add("latinLabelName",TextType::class,[
                'required'   => false,
            ])
            ->add("latinFtcName",TextType::class,[
                'required'   => false,
            ])
            ->add("law",TextType::class,[
                'required'   => false,
            ])
            ->add("description",TextType::class,[
                'required'   => false,
            ])
            ->add("fr_price",TextType::class,["label"=>"法进价",
                'required'   => false,
            ])
            ->add("jiangying_price",TextType::class,["label"=>"江阴价",
                'required'   => false,
            ])
            ->add("jing_price",TextType::class,["label"=>"仲景堂",
                'required'   => false,
            ])
            ->add("baicao_price",TextType::class,["label"=>"百草",
                'required'   => false,
            ])
            ->add("cmc",TextType::class,["label"=>"CMC",
                'required'   => false,
            ])
            ->add("old_price",TextType::class,["label"=>"旧批发价",
                'required'   => false,
            ])
            ->add("new_price",TextType::class,["label"=>"新批发价",
                'required'   => false,
            ])
            ->add("submit",SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Herb::class,
        ]);
    }
}
