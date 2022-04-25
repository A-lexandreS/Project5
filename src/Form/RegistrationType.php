<?php

namespace App\Form;


use App\Entity\Registration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('quantity', IntegerType::class, ['label' => 'Nombre de réservation'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
        ]);
    }
}
