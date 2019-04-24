<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfig("First name", "Enter your first name"))
            ->add('lastName', TextType::class, $this->getConfig("Last name", "Enter your last name"))
            ->add('email', EmailType::class, $this->getConfig("Email address", "Enter your email address"))
            ->add('picture', UrlType::class, $this->getConfig("Avatar", "Enter the url avatar"))
            ->add('tel', TelType::class, $this->getConfig("Phone number", "Enter your phone number"))
            ->add('hash', PasswordType::class, $this->getConfig("Password", "Enter your password"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfig("Password confirm", "Please repeat the password"))
            ->add('introduction', TextType::class, $this->getConfig("Introduction", "Enter a short introduction"))
            ->add('description', TextareaType::class, $this->getConfig("Description", "Enter your description"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
