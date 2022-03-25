<?php

namespace App\Form;

use App\Entity\Medical;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicalUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',ChoiceType::class,[
                "choices"=>[
                    "胶囊1"=>1,
                    "浓缩粉2"=>2,
                    "复方小药包3"=>3
                ]
            ])
            ->add('series',TextType::class,[
                'required'   => false,
                "label"=>"series"
            ])
            ->add('chinese',TextType::class,[
                'required'   => false,
                "label"=>"中文"])
            ->add('category',TextType::class,[
                'required'   => false,
                "label"=>'分类'])
            ->add('cc')
            ->add('tid',TextType::class,[
                'required'   => false,
                "label"=>"真id"])
            ->add('declareNo',TextType::class,[
                'required'   => false,
                "label"=>"申报"])
            ->add('SKU')
            ->add('EAN',TextType::class,[
                'required'   => false,
                "label"=>"EAN"])
            ->add('priceInternal',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"批内部"])
            ->add('priceCp',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"批CP"])
            ->add('priceGl',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"批GL"])
            ->add('priceShop',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"店"])
            ->add('priceInterGl',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"网GL"])
            ->add('priceInterCp',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"网CP"])
            ->add('pinyin',TextType::class,[
                'required'   => false,
                "label"=>"拼音"])
            ->add('useAs',TextareaType::class,[
                'required'   => false,
                "label"=>"用途"])
            ->add('shop',TextType::class,[
                'required'   => false,
                'empty_data' => 0,
                "label"=>"商城上架"])
            ->add('add_formula',ButtonType::class,[
                "attr"=>["class"=>"btn btn-add-formula"],
                "label"=>"更新配方"])
            ->add('formula',TextareaType::class,[
                'required'   => false,
                'disabled' => true,
                "label"=>"配方"])
            ->add('description',TextareaType::class,[
                'required'   => false,
                "label"=>"描述"])
            ->add('des2',TextareaType::class,[
                'required'   => false,
                "label"=>"description"])
            ->add('cle1',TextareaType::class,[
                'required'   => false,
                "label"=>"cle1"])
            ->add('cle2',TextareaType::class,[
                'required'   => false,
                "label"=>"cle2"])
            ->add('cle3',TextareaType::class,[
                'required'   => false,
                "label"=>"cle3"])
            ->add('cle4',TextareaType::class,[
                'required'   => false,
                "label"=>"cle4"])
            ->add("add",SubmitType::class,[
                "attr"=>["class"=>"btn btn-success"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medical::class,
        ]);
    }
}
