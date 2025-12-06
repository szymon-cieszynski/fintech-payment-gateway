<?php

declare(strict_types=1);

namespace App\Client\UI\Http\Form;

use App\Client\Domain\Client;
use App\Client\Domain\ClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Sodium\add;

class PersonalForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('surname', TextType::class)
            ->add('email', EmailType::class)
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
            ->add('country', CountryType::class)
            ->add('city')
            ->add('address')
            ->add('zipCode', TextType::class, [
                'attr' => [
                    'pattern' => '\d{2}-\d{3}',
                    'title' => 'Enter a postal code in the format XX-XXX'
                ]
            ])
            ->add('phoneNumber')
            ->add('clientType', ChoiceType::class, [
                'choices' => [
                    'Personal client' => ClientType::personal(),
                    'Business client' => ClientType::business(),
                ],
                'choice_value' => fn (?ClientType $type) => $type?->getValue()]);
//            ->add('save', SubmitType::class, ['label' => 'Register']);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);

    }
}
