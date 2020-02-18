<?php


namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomDateType extends DateType
{
  public function configureOptions(OptionsResolver $resolver)
  {
    parent::configureOptions($resolver);

    // Permet d'avoir une date de -25 ans par rapport à l'année actuelle dans easy admin
    $resolver->setDefault('years', range(date('Y')-25, date('Y')));

  }
}