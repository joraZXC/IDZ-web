<?php

namespace App\Form;

use App\Entity\Screening;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerEmail', EmailType::class, ['label' => 'Customer Email'])
            ->add('seatsCount', IntegerType::class, ['label' => 'Number of Seats'])
            ->add('screening', EntityType::class, [
                'class' => Screening::class,
                'choice_label' => function (Screening $screening) {
                    return sprintf('%s - Hall %d', 
                        $screening->getMovie()->getTitle(), 
                        $screening->getHallNumber()
                    );
                },
                'label' => 'Screening',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}