<?php

namespace App\Form;

use App\Entity\Appartment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('area', NumberType::class, array(
                'label' => 'Surface du bien*:'
            ))
            ->add('room', IntegerType::class, array(
                'label' => 'Nombre de pièce*:',
                'attr' => array('min' => 0)
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Texte de l\'annonce*:'
            ))
            ->add('ressources', CollectionType::class, array(
                'entry_type' => RessourceType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'label' => false,
                'required' => false
            ))
            ->add('garage', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => true
                ),
                'label' => 'Garage:'
            ))
            ->add('locker', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => true
                ),
                'label' => 'Casier:'
            ))
            ->add('people', TextType::class, array(
                'label' => 'Nombre de personnes:'
            ))
            ->add('bedroom', IntegerType::class, array(
                'label' => 'Nombre de chambres:',
                'attr' => array('min' => 0)
            ))
            ->add('ski', NumberType::class, array(
                'label' => 'Distance des pistes:'
            ))
            ->add('information', TextareaType::class, array(
                'label' => 'Autre information:'
            ))
            ->add('save', SubmitType::class, array(
              'label' => 'Ajouter mon annonce'
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
