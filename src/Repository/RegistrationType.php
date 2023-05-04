<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',EmailType::class,[
            'label' => 'sasisir votre Email ...',
            'attr' => [
                'placeholder'=>'exemple@gmail.com',
                'class'=>'form-control form-control-lg'
            ]
        ])
            ->add('username',TextType::class,[
                'attr' => [
                    'placeholder'=>'Emna khiari',
                    'class'=>'form-control form-control-lg'
                ]
            ])
            ->add('password' ,PasswordType::class,[
                'attr' => [
                    'placeholder'=>'*********',
                    'class'=>'form-control form-control-lg'
                ]
            ])
            ->add('confirm_password',PasswordType::class ,[
                'attr' => [
                    'placeholder'=>'*********',
                    'class'=>'form-control form-control-lg'
                ]
            ])
            ->add('adresse',TextType::class,[
                'attr' => [
                    'placeholder'=>'8 bis rue essoma soukra',
                    'class'=>'form-control form-control-lg'
                ]
            ])
            ->add('numero',TextType::class,[
                'attr' => [
                    'placeholder'=>'+216 55 969 034',
                    'class'=>'form-control form-control-lg'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'votre image de profil (image)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
