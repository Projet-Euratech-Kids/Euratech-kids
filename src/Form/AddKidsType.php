<?php

namespace App\Form;

use App\Entity\Kids;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddKidsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Prenom'])
            ->add('birthday',DateType::class, [
              'label' => 'Date de naissance',
              'format' => 'dd-MM-yyyy',
              'years' => range(date('Y')-25, date('Y'))
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Kids::class,
        ]);
    }
}
