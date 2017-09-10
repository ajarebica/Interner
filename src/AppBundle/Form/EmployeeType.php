<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('FirstName',TextType::class, array('label_attr' => array('class' => 'col-sm-8')))
        ->add('LastName',TextType::class, array('label_attr' => array('class' => 'col-sm-8')))
        ->add('BirthDate',BirthdayType::class, array('label_attr' => array('class' => 'col-sm-8')))
        ->add('BirthCountry',CountryType::class, array('attr' => array('class' => 'col-sm-8')))
        ->add('JobPosition',ChoiceType::class, array('label_attr' => array('class' => 'col-sm-8'), 'choices'  => array(
        'FE developer' => 'FE developer',
        'BE developer' => 'BE developer',
        'System administrator' => 'System administrator',
        'Sale'=> 'Sale',
        'Marketing'=> 'Marketing',)))
        ->add('Salary',MoneyType::class, array('label_attr' => array('class' => 'col-sm-8')))
        ->add('StartDate',DateType::class, array('label_attr' => array('class' => 'col-sm-8')))
        ->add('Submit',SubmitType::class, array('attr' => array('class' => 'col-sm-12')));
      
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Employee::class,
        ));
    }
}