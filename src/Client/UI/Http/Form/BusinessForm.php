<?php

declare(strict_types=1);

namespace App\Client\UI\Http\Form;

use App\Client\Domain\ClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class BusinessForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('nip', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email(['message' => 'The email "{{ value }}" is not a valid email.']),
                ],
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Password cannot be blank!'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Please enter a password with a minimum length of 5 characters!'
                    ])
            ]])
            ->add('country', CountryType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('zipCode', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^\d{2}-\d{3}$/',
                        'message' => 'Enter a postal code in the format XX-XXX'
                    ]),
                ]])
            ->add('phoneNumber', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('clientType', ChoiceType::class, [
                'choices' => [
                    'Business client' => ClientType::business(),
                ],
                'choice_value' => fn (?ClientType $type) => $type?->getValue(),
                'disabled' => true,
            ])
            ->add('clientTypeHidden', HiddenType::class, [
                'mapped' => false,
                'data' => ClientType::business()->getValue(),
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

    }
}
