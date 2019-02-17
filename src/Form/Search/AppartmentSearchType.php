<?php

namespace App\Form\Search;

use App\Entity\City;
use App\Entity\Search\AppartmentSearch;
use App\Repository\CityRepository;
use App\Repository\DepartmentRepository;
use App\Service\CityService;
use Proxies\__CG__\App\Entity\Department;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppartmentSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, array(
                'required' => false,
                'label' => false
            ))
            ->add('department', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => Department::class,
                'query_builder' => function (DepartmentRepository $er) {
                    return $er->findAllQuery();
                }
            ))
            ->add('city', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => City::class,
                'query_builder' => function (CityRepository $er) {
                    return $er->findAllQuery();
                }
            ))
            ->add('maxPrice', IntegerType::class, array(
                'label' => false,
                'required' => false
            ))
            ->add('garage', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false
                ),
                'label' => false,
                'required' => false
            ))
            ->add('locker', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false
                ),
                'label' => false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AppartmentSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
