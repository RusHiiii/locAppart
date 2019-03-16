<?php

namespace App\Form\WebApp;

use App\Entity\WebApp\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateBegin', DateType::class, array(
                'label' => 'Date début:',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ))
            ->add('dateEnd', DateType::class, array(
                'label' => 'Date fin:',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ))
            ->add('price', NumberType::class, array(
                'label' => 'Prix:',
            ))
            ->add('availability', null, array(
                'label' => 'Disponibilité:',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Price::class,
        ));
    }
}
