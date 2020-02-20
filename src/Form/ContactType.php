<?php

namespace App\Form;

<<<<<<< HEAD
=======
use App\Entity\Contact;
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label'=> 'Adresse Email'])
            ->add('name',TextType::class, ['label'=> 'Nom'])
            ->add('tel',TextType::class, ['label'=>'Téléphone'])
            ->add('message',TextareaType::class)
        ;
    }
<<<<<<< HEAD
=======

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
>>>>>>> 4ed9620d1bd7e629cfce583e2b573a971c7f9c6f
}
