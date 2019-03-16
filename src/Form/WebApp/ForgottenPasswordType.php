<?php

namespace App\Form\WebApp;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;

class ForgottenPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                  'label' => 'Email:',
                  'constraints' => array(
                    new Email(),
                  ),
                ))
            ->add('save', SubmitType::class, array(
                  'label' => 'Valider',
                ))
        ;
    }
}
