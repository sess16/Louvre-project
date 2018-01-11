<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('venueDate', DateType::class,[
                'label' => 'Date de visite :',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'js-venue-datepicker'
                ]
            ])
            ->add('customerEmail', EmailType::class,[
                'label' => 'Votre adresse email :'
            ])
            ->add('duration', EntityType::class,[
                'class' => 'App\Entity\Duration',
                'choice_label' => 'name',
                'label' => 'Type de ticket :'
            ])
            ->add('items', CollectionType::class, [
                'entry_type' => ItemType::class,
                'allow_add' => true,
                'allow_delete' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Order'
        ]);
    }

}
