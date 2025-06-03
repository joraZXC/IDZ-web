<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Screening;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScreeningTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hallNumber', null, ['label' => 'Hall Number'])
            ->add('price', null, ['label' => 'Price'])
            ->add('availableSeats', null, ['label' => 'Available Seats'])
            ->add('movie', EntityType::class, [
                'class' => Movie::class,
                'choice_label' => 'title',
                'label' => 'Movie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Screening::class,
        ]);
    }
}