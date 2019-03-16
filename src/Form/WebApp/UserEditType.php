<?php

namespace App\Form\WebApp;

use App\Entity\WebApp\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                  'label' => 'Email:',
                ))
            ->add('firstname', TextType::class, array(
                  'label' => 'Prénom:',
                ))
            ->add('lastname', TextType::class, array(
                  'label' => 'Nom:',
                ))
            ->add('gender', ChoiceType::class, array(
                  'choices' => array(
                      'Homme' => 'man',
                      'Femme' => 'women',
                  ),
                  'expanded' => true,
                  'multiple' => false,
                  'label' => 'Genre:',
                  'data' => 'man',
                ))
            ->add('notification', CheckboxType::class, array(
                'required' => false,
            ))
            ->add('save', SubmitType::class, array(
                  'label' => 'Mettre à jours',
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
