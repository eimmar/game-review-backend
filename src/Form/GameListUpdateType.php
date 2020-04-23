<?php

namespace App\Form;

use App\Entity\GameList;
use App\Enum\GameListPrivacyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameListUpdateType extends AbstractType
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
            ->add('name', null, ['constraints' => [new NotBlank(), new Length(['max' => 100])]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameList::class,
            'csrf_protection' => false,
        ]);
    }
}
