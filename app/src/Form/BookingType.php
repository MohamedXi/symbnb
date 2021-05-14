<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $frenchToDateTimeTransformer)
    {
        $this->transformer = $frenchToDateTimeTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'startDate',
                TextType::class,
                $this->getConfig(
                    'Arrival date',
                    'Date on which you wish to start the stay'
                )
            )
            ->add(
                'endDate',
                TextType::class,
                $this->getConfig(
                    'End date',
                    'Date you want to leave'
                )
            )
            ->add(
                'comment',
                TextareaType::class,
                $this->getConfig(
                    'Your comment',
                    'Add your comment here',
                    ["required" => false]
                )
            )
        ;

        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'validation_groups' => [
                'Default',
                'front'
            ]
        ]);
    }
}
