<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    private function getConfig($label, $placeholder, $options = [])
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfig('Title of your ad', 'Enter the title of your ad')
            )
            ->add(
                'slug',
                TextType::class,
                $this->getConfig('The url of your ad (optional)', 'Enter the url of your ad', [
                    'required' => false
                ])
            )
            ->add('coverImage',
                UrlType::class,
                $this->getConfig('The cover image of your ad', 'Enter the cover image url of your ad')
            )
            ->add('introduction',
                TextType::class,
                $this->getConfig('The introduction of your ad', 'Enter an introduction for your ad')
            )
            ->add('content',
                TextType::class,
                $this->getConfig('The description of your ad', 'Enter a description for your ad')
            )
            ->add('rooms',
                IntegerType::class,
                $this->getConfig('The rooms number', 'Enter the rooms number of your ad')
            )
            ->add('price',
                MoneyType::class,
                $this->getConfig('The price of your ad', 'Enter the price of your ad')
            )
            ->add('images',
                CollectionType::class, [
                    'entry_type' => ImageType::class,
                    'allow_add' => true
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
