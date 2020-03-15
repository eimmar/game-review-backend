<?php

namespace App\Form;

use App\Entity\GameList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('privacyType')
            ->add('type')
            ->add('description')
            ->add('user')
            ->add('name');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameList::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
