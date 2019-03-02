<?php

namespace App\Form\WebApp;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => 'Email:',
                'constraints' => array(
                    new Email()
                )
            ))
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Annonce' => 'annonce',
                    'Erreur' => 'erreur',
                    'RGPD' => 'rgpd',
                    'Autre' => 'autre'
                ),
                'label' => 'Sujet:'
            ))
            ->add('subject', TextType::class, array(
                'label' => 'Sujet:',
                'constraints' => array(
                    new NotBlank()
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message:',
                'constraints' => array(
                    new NotBlank(),
                    new Length(
                        array(
                            'min' => 20
                        )
                    )
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Valider'
            ))
        ;
    }
}
