<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating',
                IntegerType::class,
                $this->getConfig(
                    'Your rating on 5',
                    'Enter your rating ex: 1, 3, 4, or 5', [
                        'attr' => [
                            'min' => 0,
                            'max' => 5,
                            'step' => 1
                        ]

                ]))
            ->add('content',
                        TextareaType::class,
                            $this->getConfig(
                                'Description',
                                'Add your description')
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
