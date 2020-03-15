<?php

namespace App\Form;

use App\Entity\GameList;
use App\Enum\GameListPrivacyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('privacyType', null, [
                'constraints' => [new NotBlank(), new Choice(['choices' => [
                    GameListPrivacyType::PRIVATE,
                    GameListPrivacyType::PUBLIC,
                    GameListPrivacyType::FRIENDS_ONLY
                ]])]
            ])
            ->add('type', null, [
                'constraints' => [new NotBlank(), new EqualTo(['value' => \App\Enum\GameListType::CUSTOM])]
            ])
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
