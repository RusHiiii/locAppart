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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

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
            ->add('prices', CollectionType::class, array(
                'entry_type' => PriceType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'label' => false,
                'required' => true
            ))
            ->add('garage', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => true
                ),
                'label' => 'Garage:',
                'required' => false
            ))
            ->add('locker', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => true
                ),
                'label' => 'Casier:',
                'required' => false
            ))
            ->add('people', TextType::class, array(
                'label' => 'Nombre de personnes:',
                'required' => false
            ))
            ->add('bedroom', IntegerType::class, array(
                'label' => 'Nombre de chambres:',
                'attr' => array('min' => 0),
                'required' => false
            ))
            ->add('ski', NumberType::class, array(
                'label' => 'Distance des pistes:',
                'required' => false
            ))
            ->add('information', TextareaType::class, array(
                'label' => 'Autre information:',
                'required' => false
            ))
            ->add('adress', TextType::class, array(
                'label' => 'Adresse complète:'
            ))
            ->add('city', null, array(
                'label' => 'Lieu:',
            ))
            ->add('lat', TextType::class, array(
                'label' => false,
                'required' => false
            ))
            ->add('lng', TextType::class, array(
                'label' => false,
                'required' => false
            ))
            ->add('save', SubmitType::class, array(
              'label' => 'Ajouter mon annonce'
            ))
        ;
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Appartment::class
        ));
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if(isset($data['ressources'])){
            $data['ressources'] = array_values($data['ressources']);
        }
        if(isset($data['prices'])){
            $data['prices'] = array_values($data['prices']);
        }

        $event->setData($data);
    }
}
