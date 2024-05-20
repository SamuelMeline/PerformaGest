<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text'
            ])
            ->add('bloodgroup', ChoiceType::class, [
                'label' => 'Groupe sanguin',
                'required' => false,
                'choices' => [
                    '' => '',
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                ],
            ])
            ->add('size', IntegerType::class, [
                'label' => 'Taille (cm)',
                'required' => false,
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Poids (kg)',
                'required' => false,
            ])
            ->add('emergencyContacts', CollectionType::class, [
                'entry_type' => EmergencyContactType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'required' => false,
            ])
            ->add('antMedic', TextareaType::class, [
                'label' => 'ANT Médic',
                'required' => false,
            ])
            ->add('allergies', TextareaType::class, [
                'label' => 'ALLERGIE',
                'required' => false,
            ])
            ->add('vaccins', TextareaType::class, [
                'label' => 'VACCINS',
                'required' => false,
            ])
            ->add('tabac', TextareaType::class, [
                'label' => 'TABAC',
                'required' => false,
            ])
            ->add('alcool', TextareaType::class, [
                'label' => 'ALCOOL',
                'required' => false,
            ])
            ->add('stupefiants', TextareaType::class, [
                'label' => 'STUPÉFIANTS',
                'required' => false,
            ])
            ->add('sommeil', TextareaType::class, [
                'label' => 'SOMMEIL',
                'required' => false,
            ])
            ->add('alimentation', TextareaType::class, [
                'label' => 'ALIMENTATION',
                'required' => false,
            ])
            ->add('activitePhysique', TextareaType::class, [
                'label' => 'ACTIVITÉ PHYSIQUE',
                'required' => false,
            ])
            ->add('employeur', TextareaType::class, [
                'label' => 'EMPLOYEUR',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
