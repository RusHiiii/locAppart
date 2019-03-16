<?php

namespace App\Form\WebApp;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'constraints' => array(
                  new Regex(array(
                    'pattern' => "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/",
                    'message' => 'Le mot de passe doit contenir 6 caractères ou plus avec un nombre, une majuscule, une minuscule et un caractère spécial.',
                  )
                ), ),
                'first_options' => array('label' => 'Mot de passe:'),
                'second_options' => array('label' => 'Confirmer mot de passe:'),
                ))
            ->add('save', SubmitType::class, array(
                  'label' => 'Valider',
                ))
        ;
    }
}
