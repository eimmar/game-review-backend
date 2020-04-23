<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\GameList;
use App\Enum\GameListPrivacyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameListCreateType extends AbstractType
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
            ->add('user')
            ->add('games', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => ['class' => Game::class],
                'allow_add' => true,
                'allow_delete' => true,
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
