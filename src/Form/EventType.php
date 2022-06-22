<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'fieldSize'],
            ])
            ->add('picture', FileType::class, [
                'required' => false,
                'label' => 'Image',
                'mapped' => false,
                'attr' => ['class' => 'uploadFile'],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Svp, mettez une image valide',
                    ]),
                ],
            ])
            ->add('startedAt', DateTimeType::class, [
                'label' => 'Date de début',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('endedAt', DateTimeType::class, [
                'label' => 'Date de fin',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('maxRegistration', IntegerType::class, [
                'label' => 'Maximum de place disponible',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix de la prestation',
                'attr' => ['class' => 'fieldSizeMoney'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descriptif de l\'évènnement',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
