<?php

namespace App\Form;

use App\Entity\Appartment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                  'label' => 'Titre*:'
                ))
            ->add('type', null, array(
                'label' => 'Type de bien*:'
            ))
            ->add('area', TextType::class, array(
                  'label' => 'Surface du bien*:'
                ))
            ->add('room', TextType::class, array(
                'label' => 'Nombre de pièce*:'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Texte de l\'annonce*:'
            ))
            ->add('ressources', CollectionType::class, array(
                'entry_type' => RessourceType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true
            ))
            ->add('save', SubmitType::class, array(
                  'label' => 'Valider'
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Appartment::class
        ));
    }
}
