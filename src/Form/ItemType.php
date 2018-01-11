<?php

namespace App\Form;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom :'
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Date de naissance :',
                'widget' => 'single_text',
                'html5' => 'false',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'js-birth-datepicker'
                ]
            ])
            ->add('country', EntityType::class, [
                'class' => 'App\Entity\Country',
                'choice_label' => 'name',
                'label' => 'Pays :',
                'expanded' => false,
                'query_builder' => function (CountryRepository $repo) {
                    return $repo->getCountriesByAlphabeticalOrder();
                },
                'preferred_choices' => function (Country $country, $key, $index) {
                    return $country->getId() == 75;
                }
            ])
            ->add('reducedRate', CheckboxType::class, [
                'label' => 'Tarif réduit :',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Item'
        ]);
    }

}
