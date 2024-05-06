<?php

namespace App\Form;

use App\Entity\Patients;
use App\Entity\Categories;
use App\Entity\References;
use App\Entity\Distributeurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class PatientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du Patient',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom du Patient',
            ])
            ->add('age', TextType::class, [
                'label' => 'Age du Patient',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone du Patient',
            ])
            ->add('contact_urgence', TextType::class, [
                'label' => 'Contact d\'urgence',
            ])
            // Autoriser les caractères spéciaux du groupe sanguin
            ->add('groupe_sanguin', TextType::class, [
                'label' => 'Groupe Sanguin',
            ])
            ->add('taille', TextType::class, [
                'label' => 'Taille',
            ])
            ->add('poids', TextType::class, [
                'label' => 'Poids',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patients::class,
        ]);
    }
}
