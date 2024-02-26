<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required'=>true,
                'label'=>"Votre email",
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Veuillez saisir votre mail'
                    ]),
                ]
            ])
            ->add('titre', TextType::class, [
                'required'=>true,
                'label'=>"Titre",
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Veuillez saisir un titre'
                    ]),
                ]
            ])
            ->add('description', TextAreaType::class, [
                'required'=>true,
                'label'=>"Message",
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Veuillez saisir votre message'
                    ]),
                ]
            ])
            ->add('ENVOYER', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
